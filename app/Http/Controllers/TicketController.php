<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Subtask;
use App\Models\Mubadara;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Models\EmployeePosition;
use App\Models\TicketTransition;
use App\Models\EmployeePositionRelation;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function ticketshow(){
        //return view tickets.show
        return view('tickets.ticketshow');
     }
    public function ticketfilter(){
        //return view tickets.filter
        return view('tickets.filter');
    }
    public function index()
    {
        $current_user_id = auth()->user()->id;
        $users = User::all();
        $current_user_id = EmployeePosition::where('user_id',$current_user_id)->first()->id;
        // dd(current_user_position()->id);
        // dd($current_id);
        return View('/tickets/index', [
            'mubadaras' => Mubadara::where('user_id',$current_user_id)->get(),
            'mytickets' => Ticket::where('user_id',$current_user_id)->orderBy('id', 'desc')->get(),
            'approved_tickets' => Ticket::where('status', 'approved')->where('to_id', $current_user_id)->where(function ($query) {
                $query->where('task_id', 0)->orWhereNull('task_id');
            })->orderBy('id', 'desc')->get(),
            'rejected_tickets' => Ticket::where('status','rejected')->where('user_id',$current_user_id)->orderBy('id', 'desc')->get(),
            'pending_tickets' => Ticket::where('status','pending')->where('user_id',$current_user_id)->orderBy('id', 'desc')->get(),
            'needapproval_tickets' => Ticket::where('status','pending')->where('to_id',$current_user_id)->orderBy('id', 'desc')->get(),
            'sent_tickets' => Ticket::where('from_id',current_user_position()->id)->orderBy('id', 'desc')->get(),
            'users' => $users,
        ]);
    }


    public function history()
    {
        $ticket_id = request()->route('ticket_id');
        $ticket = Ticket::where('id', $ticket_id)->first();
        $ticket_transitions = TicketTransition::where('ticket_id', $ticket_id)->get();
        
        return view('tickets.history', compact('ticket', 'ticket_transitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeePositions = EmployeePosition::all();
        return view('tickets/create',compact('employeePositions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return 'afasdf';

         // Validate the request data including ticket_id
       

         dd(count($request->to_id));
         foreach ($request->to_id as $to_id) {
            $ticket = new Ticket();
            $ticket->name = $request->name;
            $ticket->user_id = $to_id; // Assign the current to_id
            $ticket->from_id = current_user_position()->id;
            $ticket->todo_id = 0;
            $ticket->to_id = $to_id;
            $ticket->note = $request->note;
            $ticket->due_time = $request->duetime;
            $ticket->task_id = $request->task_id;
            $ticket->save();
        
            $createdTicketId = $ticket->id;
        
            // Create and save the ticket transition with ticket_id
            $ticketTransition = TicketTransition::create([
                'ticket_id' => $createdTicketId, // Include ticket_id in the creation
                'from_state' => current_user_position()->id,
                'to_state' => $to_id,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'sent',
            ]);
        }
        


        return back()->with('success', 'تم إضافة التذكرة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function showwithmessages($id)
    {
        $ticket = Ticket::with('messages.user')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function storeMessage(Request $request, $ticketId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = new Message();
        $message->content = $request->content;
        $message->ticket_id = $ticketId;
        $message->user_id = current_user_position()->id;
        $message->save();

        return redirect()->route('tickets.showwithmessages', $ticketId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
                
        $employeePositions = EmployeePosition::all();

        $ticket = Ticket::where('id',$ticket->id)->first();
        return view('tickets/edit',compact('ticket','employeePositions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        
        $ticket = Ticket::findOrFail($request->id);
        //check if ticket from_id is equal to current_employee_position->id 
        if($ticket->from_id != current_user_position()->id){
            return redirect()->route('tickets.index')->with('error', 'You are not allowed to update this ticket');
        }
        $ticket->name = $request->name;
        $ticket->note = $request->note;
        $ticket->due_time = $request->duetime;
        $ticket->save();
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully');
    }

    public function status(Request $request, Ticket $ticket)
    {
        $ticket = Ticket::findOrFail($request->id);
        
    //    dd($request->all());
        if($request->task_id !=0 && $request->status !='rejected'){
            // dd('here');
            $employee_parent_id=  EmployeePositionRelation::where('child_id',$ticket->user_id)->first()->parent_id;
            $ticket->status = $request->status ?? 'pending';


            
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


        }else{
            $ticket->status = $request->status;

           if($ticket->status == 'rejected'){
                // Save rejection reason in ticket notes
                if($request->has('rejection_reason') && !empty($request->rejection_reason)) {
                    $ticket->note = $request->rejection_reason;
                }
                
                $ticketTransition = TicketTransition::create([
                    'ticket_id' =>  $ticket->id, 
    
                    
                    'from_state' =>current_user_position()->id,
                    'to_state' => EmployeePosition::where('id', $ticket->from_id)->first()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'status' => $request->status,
                ]);
               }elseif($ticket->status == 'approved'){
                $ticketTransition = TicketTransition::create([
                    'ticket_id' =>  $ticket->id, 
                    'from_state' => EmployeePosition::where('id', $ticket->from_id)->first()->id,
                    'to_state' =>current_user_position()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'status' => $request->status,
                ]);
               }
            

        }


        $ticket->save();
        
        // Add success message for rejection
        if($ticket->status == 'rejected') {
            return redirect()->back()->with('success', 'تم رفض التذكرة بنجاح مع تسجيل سبب الرفض');
        }
        
        return redirect()->back();
    }

    public function settouser(Request $request, Ticket $ticket)
    {
        

      

       

        if(!isset($request->task_id) || $request->task_id == 0){
            // dd('hey one');
        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->status = 'pending';
        $ticket->user_id =  current_user_position()->id;
        $ticket->to_id =  $request->user_id;
        $ticket->save();
        }else{
            
            $ticket = Ticket::findOrFail($request->ticket_id);
            $ticket->status = 'transfered';
            $ticket->save();
            
            // if(!isset($request->ticket_missio))
            if(isset($request->ticket_mission)){
            // dd('hey two');
            // dd($request->user_id);

            $parentt = EmployeePositionRelation::where('child_id',$request->user_id)->first()->parent_id;
            $employee_parent_id=$parentt;
            // $employee_parent_id=  EmployeePosition::where('user_id', $parentt )->first()->id;
            $ticketTransition = TicketTransition::create([
                'ticket_id' => $request->ticket_id, // Include ticket_id in the creation
                'from_state' => $parentt,
                'to_state' => $request->user_id,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'sent',
            ]);
            // dd($employee_parent_id);
          //  dd( $employee_parent_id);
            $employee_id =  $request->user_id;
        
          //  dd($employee_parent_id . ' -1- '.$employee_id);
        }else{
            
        $employee_id=  EmployeePosition::where('user_id',auth()->id())->first()->id;
        $employee_parent_id=  EmployeePositionRelation::where('child_id',$employee_id)->first()->parent_id;
     //   die('aa');
        //dd($employee_parent_id . ' -2- '.$employee_id);
    }

    // dd(icket::find($request->ticket_id)->first())
    // dd(Ticket::find($request->ticket_id)->due_time);
        // dd($employee_parent_id);
        
        $subtaskExists = Subtask::where('ticket_id', $ticket->id)->first();

        if (!$subtaskExists) {
            $subtask = new Subtask();
            $subtask->name = $request->name;
            $subtask->percentage = 0;
            $subtask->parent_id = $request->task_id;
            $subtask->done = 0;
            $subtask->user_id = $employee_id;
            $subtask->parent_user_id = $employee_parent_id;
            $subtask->due_time = Ticket::find($request->ticket_id)->due_time;
            $subtask->ticket_id = $ticket->id;
            $subtask->start_date = $ticket->start_date;
            $subtask->notes = $ticket->note;
            $subtask->save();
        }

        }


        $employee = EmployeePosition::find($request->user_id);

        // Check if the employee exists and has an associated user
        if ($employee && $employee->user && current_user_position()->id != $request->user_id) {
            $email = $employee->user->email;            // Send the email if not in local environment
            if (env('ENVO') !== 'local') {
                try {
                    Mail::raw(
                        "عزيزي {$employee->user->name},\n\n" .
                        "تم إسناد تذكرة عمل جديدة إليك من نظام إدارة التذاكر.\n\n" .
                        "تفاصيل التذكرة:\n" .
                        "العنوان: {$request->name}\n" .
                        "المرسل: " . current_user_position()->name . "\n" .
                        "التاريخ: " . date('Y-m-d H:i:s') . "\n\n" .
                        "يرجى تسجيل الدخول إلى النظام لمراجعة التذكرة والعمل عليها.\n\n" .
                        "شكراً لكم\n" .
                        "فريق نظام إدارة التذاكر",
                        function ($message) use ($email) {
                            $message->to($email)
                                    ->subject('تذكرة عمل جديدة - نظام إدارة التذاكر')
                                    ->from(config('mail.from.address'), config('mail.from.name'));
                        }
                    );                } catch (\Exception $e) {
                    Log::error('Failed to send ticket notification email: ' . $e->getMessage());
                }
            }
        }
        calculatePercentages();

        return redirect()->back();
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully');
    }
    

    public function deleteTicket($ticketId)
    {
        // dd('ssf');
        // Delete the ticket

        $ticket_from = Ticket::where('id',$ticketId)->first()->from_id;
        if(current_user_position()->id == $ticket_from){
        Ticket::where('id', $ticketId)->delete();

        // Delete subtasks associated with the ticket
        Subtask::where('ticket_id', $ticketId)->delete();

        return back()->with('success', 'Ticket and associated subtasks deleted successfully.');
    }
    }

    /**
     * Admin: Display all tickets in the system (only for ADMIN_ID users)
     */
    public function adminIndex()
    {
        // Check if current user position is in ADMIN_ID array
        $adminIds = explode(',', env('ADMIN_ID', ''));
        $currentUserPositionId = current_user_position()->id;
        
        if (!in_array($currentUserPositionId, $adminIds)) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $tickets = Ticket::with(['employeePosition.user', 'fromEmployeePosition.user', 'subtasks'])
            ->orderBy('id', 'desc')
            ->get();

        return view('tickets.admin_index', compact('tickets'));
    }

    /**
     * Admin: Show edit form for any ticket
     */    public function adminEdit($id)
    {
        // Check if current user position is in ADMIN_ID array
        $adminIds = explode(',', env('ADMIN_ID', ''));
        $currentUserPositionId = current_user_position()->id;
        
        if (!in_array($currentUserPositionId, $adminIds)) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $ticket = Ticket::with(['employeePosition.user', 'fromEmployeePosition.user', 'subtasks', 'images'])->findOrFail($id);
        $employees = EmployeePosition::with('user')->get();

        return view('tickets.admin_edit', compact('ticket', 'employees'));
    }

    /**
     * Admin: Update any ticket
     */    public function adminUpdate(Request $request, $id)
    {
        // Check if current user position is in ADMIN_ID array
        $adminIds = explode(',', env('ADMIN_ID', ''));
        $currentUserPositionId = current_user_position()->id;
        
        if (!in_array($currentUserPositionId, $adminIds)) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'note' => 'nullable|string',
            'due_time' => 'required|date',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif|max:10240' // 10MB max each file
        ]);

        $ticket = Ticket::findOrFail($id);
        
        // Update ticket data
        $ticket->update([
            'name' => $request->name,
            'note' => $request->note,
            'due_time' => $request->due_time,
        ]);

        $uploadedFilesCount = 0;
        $successMessage = 'تم تحديث التذكرة بنجاح.';

        // Handle multiple file uploads
        if ($request->hasFile('files')) {
            try {
                foreach ($request->file('files') as $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $filename = pathinfo($originalName, PATHINFO_FILENAME);
                        $randomStr = \Str::random(10);
                        $filename = $filename . '_' . $randomStr . '.' . $extension;
                        $path = $file->store('public/uploads');
                        
                        // Create new image record
                        $image = new \App\Models\Image([
                            'filename' => $filename, 
                            'filepath' => $path
                        ]);
                        $ticket->images()->save($image);
                        $uploadedFilesCount++;
                    }
                }
                
                if ($uploadedFilesCount > 0) {
                    $successMessage = "تم تحديث التذكرة وإضافة {$uploadedFilesCount} ملف جديد بنجاح.";
                }
            } catch (\Exception $e) {
                return redirect()->route('tickets.admin.edit', $id)
                    ->with('error', 'حدث خطأ أثناء رفع الملفات: ' . $e->getMessage());
            }
        }

        // Update associated subtask if it exists (only name, note, and due_time)
        $subtask = \App\Models\Subtask::where('ticket_id', $id)->first();
        if ($subtask) {
            $subtask->update([
                'name' => $request->name,
                'notes' => $request->note,
                'due_time' => $request->due_time,
            ]);
        }

        return redirect()->route('tickets.admin.edit', $id)->with('success', $successMessage);
    }

    /**
     * Admin: Remove a file from ticket
     */    public function adminRemoveFile(Request $request, $id)
    {
        // Check if current user position is in ADMIN_ID array
        $adminIds = explode(',', env('ADMIN_ID', ''));
        $currentUserPositionId = current_user_position()->id;
        
        if (!in_array($currentUserPositionId, $adminIds)) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $request->validate([
            'image_id' => 'required|exists:images,id'
        ]);

        $ticket = Ticket::findOrFail($id);
        $image = \App\Models\Image::where('id', $request->image_id)
                                  ->where('imageable_type', 'App\Models\Ticket')
                                  ->where('imageable_id', $id)
                                  ->firstOrFail();

        try {
            // Delete the file from storage
            if (Storage::exists($image->filepath)) {
                Storage::delete($image->filepath);
            }

            // Delete the image record
            $image->delete();

            return redirect()->route('tickets.admin.edit', $id)->with('success', 'تم حذف الملف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('tickets.admin.edit', $id)->with('error', 'حدث خطأ أثناء حذف الملف: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Delete any ticket
     */
    public function adminDestroy($id)
    {
        // Check if current user position is in ADMIN_ID array
        $adminIds = explode(',', env('ADMIN_ID', ''));
        $currentUserPositionId = current_user_position()->id;
        
        if (!in_array($currentUserPositionId, $adminIds)) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $ticket = Ticket::findOrFail($id);
        
        // Delete associated subtasks first
        Subtask::where('ticket_id', $id)->delete();
        
        // Delete the ticket
        $ticket->delete();

        return redirect()->route('tickets.admin.index')->with('success', 'Ticket and associated subtasks deleted successfully.');
    }
}
