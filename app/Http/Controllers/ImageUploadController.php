<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Image; // Import the 'Image' class from the appropriate namespace
use App\Models\Ticket; // Import the 'Image' class from the appropriate namespace
use App\Models\Subtask; // Import the 'Image' class from the appropriate namespace
use App\Models\TicketTransition; // Import the 'Image' class from the appropriate namespace
use App\Models\EmployeePosition;
use App\Models\EmployeePositionRelation; // Import the 'EmployeePositionRelation' class from the appropriate namespace
use Illuminate\Support\Facades\Mail; // Import the 'Mail' class from the appropriate namespace

class ImageUploadController extends Controller
{
    public function uploadFiles(Request $request, $modelType, $modelId)
    {
        // dd($request->to_id);
        $to_id_v = explode(',', $request->to_id);
        // return count($to_id_v).'---';
        // if(count($to_id_v) == 1 && current_user_position()->id == $to_id_v[0]){
            
           
        // }
        // dd($to_id_v);
        
         $names = $request->name; // Retrieve the array of names

    // Ensure `name` is an array
    if (!is_array($names)) {
        return response()->json(['message' => 'Invalid names input'], 400);
    }
        foreach ($to_id_v as $to_id) {
 foreach ($names as $name) {
            $employee = EmployeePosition::find($to_id);

          

        // dd($request->name);
        $modelType='ticket';
        
        $ticket = new Ticket();
        $ticket->name = $name;
        $ticket->user_id = $to_id;
        $ticket->from_id = current_user_position()->id;
        $ticket->todo_id = 0;
        $ticket->to_id = $to_id;
        $ticket->note = $request->note;
        $ticket->due_time = $request->duetime;
        $ticket->task_id = $request->task_id;
        $ticket->start_date = now();

        if($request->myself==1 && current_user_position()->id == $to_id){
            $ticket->status = 'transfered';
        }else{
            $ticket->status = 'pending';
        }   

        
        $ticket->save();
        
        $createdTicketId = $ticket->id;
        $modelId =  $createdTicketId;
  
        
        // Create and save the ticket transition with ticket_id
        try {
            $ticketTransition = TicketTransition::create([
                'ticket_id' => $createdTicketId, // Include ticket_id in the creation
                'from_state' => current_user_position()->id,
                'to_state' => $to_id,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'sent',
            ]);
        } catch (\Exception $e) {
            // Handle the error
            // You can log the error, return an error response, etc.
           dd('Error creating ticket transition: ' . $e->getMessage());
        
            // Optionally, you can return a custom error response
            return response()->json(['error' => 'Failed to create ticket transition.'], 500);
        }
        
     





        if(count($to_id_v) == 1 && current_user_position()->id == $to_id_v[0] && $request->task_id != 0){

        $parentRelation = EmployeePositionRelation::where('child_id',$ticket->user_id)->first();
        $employee_parent_id = $parentRelation ? $parentRelation->parent_id : null;

        if($request->myself==1 && current_user_position()->id == $to_id){
            $ticket->status = 'transfered';
        }else{
            $ticket->status = 'pending';
        }   

        
        $subtaskExists = Subtask::where('ticket_id', $ticket->id)->first();

        if (!$subtaskExists) {
            $subtask = new Subtask();
            $subtask->name = $ticket->name;
            $subtask->percentage = 0;
            $subtask->parent_id = $ticket->task_id;
            $subtask->done = 0;
            $subtask->user_id = $ticket->user_id;
            $subtask->parent_user_id = $employee_parent_id;
            $subtask->due_time = $ticket->due_time;
            $subtask->start_date = $ticket->start_date;
            $subtask->ticket_id = $ticket->id;
            $subtask->notes = $ticket->note;

            $subtask->save();
        }
        

try{
    $ticketTransition = TicketTransition::create([
        'ticket_id' =>  $ticket->id, 
        'from_state' => EmployeePosition::where('id', $ticket->from_id)->first()->id,
        'to_state' =>current_user_position()->id,
        'date' => date('Y-m-d H:i:s'),
        'status' => 'pending-upload',
    ]);

}catch(\Exception $e){
    dd($e);
}
        

}










        // dd('afdsf');
        // Convert model type from input into a fully qualified class name
        $modelClass = '\\App\\Models\\' . ucfirst($modelType);

        if (!class_exists($modelClass)) {
            return response()->json(['message' => 'Invalid model type'], 400);
        }

        $model = $modelClass::find($modelId);
        if (!$model) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($originalName, PATHINFO_FILENAME);
                $randomStr = Str::random(10); // Generates a random string of 10 characters
                $filename = $filename . '_' . $randomStr . '.' . $extension;
                $path = $file->store('public/uploads');
                $image = new Image(['filename' => $filename, 'filepath' => $path]);
                $model->images()->save($image);
            }
            
    

            // dd(current_user_position()->id);
            
            // return response()->json(['message' => 'Files uploaded and attached successfully']);        } else {
            // return response()->json(['message' => 'No files provided']);
        }
        
        // Check if the employee exists and has an associated user and send email notification
        if ($employee && $employee->user && current_user_position()->id != $to_id) {
            $email = $employee->user->email;
            
            // Send the email if not in local environment
            if (env('ENVO') !== 'local') {
                $ticketTitle = $name; // Use the current name from the loop
                $emailBody = "عزيزي {$employee->user->name}،\n\n" .
                             "تحية طيبة وبعد،\n\n" .
                             "نود إعلامكم بأنه تم إرسال تذكرة جديدة إليكم تحتاج إلى مراجعتكم والعمل عليها.\n\n" .
                             "تفاصيل التذكرة:\n" .
                             "العنوان: {$ticketTitle}\n" .
                             "تاريخ الإرسال: " . date('Y-m-d H:i:s') . "\n\n" .
                             "يرجى الدخول إلى النظام لمراجعة التذكرة والعمل عليها في أقرب وقت ممكن.\n\n" .
                             "في حال وجود أي استفسارات، يرجى التواصل معنا.\n\n" .
                             "مع أطيب التحيات،\n" .
                             "فريق إدارة النظام";

                try {
                    Mail::raw($emailBody, function ($message) use ($email) {
                        $message->to($email)
                                ->subject('إشعار رسمي: تذكرة جديدة تتطلب مراجعتكم');
                    });
                } catch (\Exception $e) {
                    // Optionally log the error, but do not stop execution
                    // \Log::error('Failed to send email: ' . $e->getMessage());
                }
            }
        }
        
          }
        

    }
    
    return true;
    
    
    }
    public function uploadFilesUpdate(Request $request, $modelType, $modelId)
    {
        // dd($request->name);
        $modelType='ticket';
     
          $ticket = Ticket::findOrFail($request->ticket_id);
        //check if ticket from_id is equal to current_employee_position->id 
        if($ticket->from_id != current_user_position()->id){
            return redirect()->route('tickets.index')->with('error', 'You are not allowed to update this ticket');
        }
        
        // Handle name as array or string
        $ticketName = is_array($request->name) ? $request->name[0] : $request->name;
        
        $ticket->name = $ticketName;
        $ticket->note = $request->note;
        $ticket->due_time = $request->duetime;
        $ticket->save();
        
        $subtask = Subtask::where('ticket_id', $request->ticket_id)->first();

        if ($subtask) {
            $subtask->name = $ticketName;
            $subtask->notes = $request->note;
            $subtask->due_time = $request->duetime;
            $subtask->save();
        } else {
            // Handle the case where no subtask is found
            // For example, return an error response
            return response()->json(['error' => 'Subtask not found'], 404);
        }
        


        
        $createdTicketId = $ticket->id;
        $modelId =  $createdTicketId;
  
        
        // Create and save the ticket transition with ticket_id
        // $ticketTransition = TicketTransition::create([
        //     'ticket_id' => $createdTicketId, // Include ticket_id in the creation
        //     'from_state' => current_user_position()->id,
        //     'to_state' => $request->to_id,
        // ]);
     
        // dd('afdsf');
        // Convert model type from input into a fully qualified class name
        $modelClass = '\\App\\Models\\' . ucfirst($modelType);

        if (!class_exists($modelClass)) {
            return response()->json(['message' => 'Invalid model type'], 400);
        }

        $model = $modelClass::find($modelId);
        if (!$model) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($originalName, PATHINFO_FILENAME);
                $randomStr = Str::random(10); // Generates a random string of 10 characters
                $filename = $filename . '_' . $randomStr . '.' . $extension;
                $path = $file->store('public/uploads');
                $image = new Image(['filename' => $filename, 'filepath' => $path]);
                $model->images()->save($image);
            }
            
    

            // dd(current_user_position()->id);
            
            return response()->json(['message' => 'Files uploaded and attached successfully']);
        } else {
            return response()->json(['message' => 'No files provided']);
        }
    }
}



