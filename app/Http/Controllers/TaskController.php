<?php

namespace App\Http\Controllers;

use App\Models\Moashermkmf;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('/task/index', [
            'tasks' => Task::all()
        ]);
    }

    public function getTasksByUserId(Request $request)
    {
        // return  $userId->count();
        $userId = $request->user_id[0];
        // return $userId;
        // return  count($userId);

        // Check if current user has permission to view tasks for the selected employee position
        $currentUser = auth()->user();
        $currentUserPositionId = current_user_position()->id; // Assuming this field exists
// return $currentUserPositionId . '   '. $userId . '   ';
        if($userId == $currentUserPositionId) {

               $taskIds = \App\Models\TaskUserAssignment::where('employee_position_id', $userId)
            ->where('type', 'task')
            ->pluck('task_id');

            
            // Also get tasks that are directly assigned (for backward compatibility)
            $directlyAssignedTasks = Task::where('user_id', $userId)->pluck('id');
            // return $directlyAssignedTasks;
            
            // Merge both collections and get unique task IDs
            $allTaskIds = $taskIds->merge($directlyAssignedTasks)->unique();
            
            // Get the actual task objects
            $tasks = Task::whereIn('id', $allTaskIds)->get();
            // return $tasks;

        // If returning HTML directly
        return view('partials.selectedUserTasks', compact('tasks'));
            // User is trying to view their own tasks, which is allowed
            // $userId = $currentUser->id; // Use current user's ID
            // return 'this is me';
        }elseif($currentUserPositionId == 4){
               $taskIds = \App\Models\TaskUserAssignment::where('employee_position_id', $userId)
            ->where('type', 'task')
            ->pluck('task_id');
            
            // Also get tasks that are directly assigned (for backward compatibility)
            $directlyAssignedTasks = Task::where('user_id', $userId)->pluck('id');
            
            // Merge both collections and get unique task IDs
            $allTaskIds = $taskIds->merge($directlyAssignedTasks)->unique();
            
            // Get the actual task objects
            $tasks = Task::whereIn('id', $allTaskIds)->get();
            // return $tasks;

        // If returning HTML directly
        return view('partials.selectedUserTasks', compact('tasks'));
            // return 'this is the boss';
        } else {
            // Check if the target user is in the current user's hierarchy (as a descendant)
            $whereintheloop = $userId;
            $foundInHierarchy = false;
            
            while($whereintheloop != 4 && !$foundInHierarchy){
                // Move up the hierarchy from the target user
                $parentRelation = \App\Models\EmployeePositionRelation::where('child_id',$whereintheloop)->first();
                if($parentRelation) {
                    $whereintheloop = $parentRelation->parent_id;
                    
                    // Check if we've reached the current user in the hierarchy
                    if($whereintheloop == $currentUserPositionId) {
                        $foundInHierarchy = true;
                        break;
                    }
                } else {
                    break; // No parent found, exit loop
                }
            }
            
        if(!$foundInHierarchy) {
                $tasks = [];

        // If returning HTML directly
                return view('partials.selectedUserTasks', compact('tasks'));
        }else{
                 $taskIds = \App\Models\TaskUserAssignment::where('employee_position_id', $userId)
            ->where('type', 'task')
            ->pluck('task_id');
            
            // Also get tasks that are directly assigned (for backward compatibility)
            $directlyAssignedTasks = Task::where('user_id', $userId)->pluck('id');
            
            // Merge both collections and get unique task IDs
            $allTaskIds = $taskIds->merge($directlyAssignedTasks)->unique();
            
            // Get the actual task objects
            $tasks = Task::whereIn('id', $allTaskIds)->get();
            

        // If returning HTML directly
        return view('partials.selectedUserTasks', compact('tasks'));
            }
        }

        
        // Get tasks assigned to this user using the new assignment system
       

        // If returning JSON
        // return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return View('/task/create',[
            'moashermkmfs' => Moashermkmf::where('parent_id', (int)$_GET['mubadara'])->get(),
            'mubadara'=>(int)$_GET['mubadara'],
            


        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('a');
       
        // dd($request->sr_week);
           // Validation
    $validator = Validator::make($request->all(), [
        'marketing_cost' => 'required|numeric',
        'output' => 'required|string',
        'real_cost' => 'required|numeric',
        'sp_week' => 'required|date',
        'ep_week' => 'required|date',
        'sr_week' => 'nullable|date',
        'er_week' => 'nullable|date',
        'r_money_paid' => 'required|numeric',
        'marketing_verified' => 'required|numeric',
        'complete_percentage' => 'required|integer|between:0,100',
        'quality_percentage' => 'required|integer|between:0,100',
        'evidence' => 'required|integer|between:0,100',
        'roi' => 'required|numeric',
        'customers_count' => 'required|integer',
        'perf_note' => 'required|string',
        'recomm' => 'required|string',
        'notes' => 'required|string',
    ]);

    if ($validator->fails()) {
       // dd($validator);
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

        //$hadafstrategy = Hadafstrategy::find($request->input('hadafstrategy')[0])->id;
       // dd($hadafstrategy);
        $task  = new Task();
        $task->name = $request->input('name');

        $task->marketing_cost = $request->marketing_cost;
        $task->real_cost = $request->real_cost;
        $task->sp_week = $request->sp_week;
        $task->ep_week = $request->ep_week;
        $task->sr_week = $request->sr_week;
        $task->er_week = $request->er_week;
        $task->r_money_paid = $request->r_money_paid;
        $task->marketing_verified = $request->marketing_verified;
        $task->complete_percentage = $request->complete_percentage;
        $task->quality_percentage = $request->quality_percentage;
        $task->evidence = $request->evidence;
       
        $task->roi = $request->roi;
        $task->customers_count = $request->customers_count;
        $task->perf_note = $request->perf_note;
        $task->recomm = $request->recomm;
        $task->notes = $request->notes;
        $task->percentage = 0;
        $task->output = $request->output;

        // dd($request->input('mubadara'));
        $task->parent_id = $request->input('mubadara');
        $task->save();
        //get last inserted id
        $mubadara_id = $task->id;
        //insert into pivot table
        foreach($request->input('moashermkmfs') as $moashermkmf)
        {
            $task->moashermkmfs()->attach($moashermkmf);
        }

        calculatePercentages();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //  dd($task);
        
        $task = Task::where('id',$task->id)->first();
        // dd($task);
        return View('task.edit', [
            'task' => $task,
            'item' => $task,
            'moashermkmfs' => Moashermkmf::all(),
            'mubadara'=>$task->parent_id,
            'id' => $task->id,
        ]);
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'output' => 'required|string',
        'marketing_cost' => 'required|numeric',
        'real_cost' => 'required|numeric',
        'sp_week' => 'required|date',
        'ep_week' => 'required|date',
        // If sr_week and er_week should be editable, validate them here
        'r_money_paid' => 'required|numeric',
        'marketing_verified' => 'required|numeric',
        'complete_percentage' => 'required|numeric|min:0|max:100',
        'quality_percentage' => 'required|numeric|min:0|max:100',
        'evidence' => 'nullable|numeric',
        'roi' => 'required|numeric',
        'customers_count' => 'required|numeric',
        'perf_note' => 'nullable|string',
        'recomm' => 'nullable|string',
        'notes' => 'nullable|string',
        // Assuming 'moashermkmfs' is an array of related entity IDs
        'moashermkmfs' => 'nullable|array',
        'moashermkmfs.*' => 'exists:moashermkmfs,id', // Adjust the table name as necessary
        'mubadara' => 'required|numeric|exists:mubadaras,id', // Ensure mubadara ID is valid
    ]);

    // Find the task by ID and update it with validated data
    $task = Task::findOrFail($id);
    $task->update([
        'name' => $validated['name'],
        'output' => $validated['output'],
        'marketing_cost' => $validated['marketing_cost'],
        'real_cost' => $validated['real_cost'],
        'sp_week' => $validated['sp_week'],
        'ep_week' => $validated['ep_week'],
        // Handle sr_week and er_week if they're part of the request
        'r_money_paid' => $validated['r_money_paid'],
        'marketing_verified' => $validated['marketing_verified'],
        'complete_percentage' => $validated['complete_percentage'],
        'quality_percentage' => $validated['quality_percentage'],
        'evidence' => $validated['evidence'],
        'roi' => $validated['roi'],
        'customers_count' => $validated['customers_count'],
        'perf_note' => $validated['perf_note'],
        'recomm' => $validated['recomm'],
        'notes' => $validated['notes'],
        // Assuming 'mubadara' is a direct column on this model
        'parent_id' => $validated['mubadara'],
    ]);

    // If 'moashermkmfs' is a relationship, handle syncing or updating separately
    // Example for a ManyToMany relationship
    if (isset($validated['moashermkmfs'])) {
        $task->moashermkmfs()->sync($validated['moashermkmfs']);
    }

    // Redirect the user with a success message
    return redirect()->route('task.index')->with('success', 'Task updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
{
    // Delete the Task model instance
    $task->delete();

    // Redirect the user back with a success message. Adjust the route as necessary.
    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
}

    /**
     * Toggle task hidden status (pause/unpause)
     */
    public function toggleHidden(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->hidden = $request->hidden;
        $task->save();

        return response()->json([
            'success' => true,
            'message' => $task->hidden ? 'Task paused successfully' : 'Task resumed successfully'
        ]);
    }
}
    