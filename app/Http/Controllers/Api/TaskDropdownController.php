<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\EmployeePosition;
use App\Http\Controllers\Controller;

class TaskDropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {

        // $current_user_id = auth()->id(); // because why call the user just to get the id?
        // $employee_position = EmployeePosition::where('id', 7)->firstOrFail();
        
        // $childPositionIds = \App\Models\EmployeePositionRelation::where('parent_id', $request->user_id)
        //                                                         ->get()
        //                                                         ->pluck('childPosition')
        //                                                         ->toArray();
    
        // Get tasks assigned to this user using the new assignment system
        $taskIds = \App\Models\TaskUserAssignment::where('employee_position_id', $request->user_id)
            ->where('type', 'task')
            ->pluck('task_id');
        
        // Also get tasks that are directly assigned (for backward compatibility)
        $directlyAssignedTasks = \App\Models\Task::where('user_id', $request->user_id)->pluck('id');
        
        // Merge both collections and get unique task IDs
        $allTaskIds = $taskIds->merge($directlyAssignedTasks)->unique();
        
        // Get the actual task objects
        $tasks = \App\Models\Task::whereIn('id', $allTaskIds)->get();
    
        $options = '<option value="0">اختر اي قيمة من القيم</option>';
        foreach ($tasks as $task) {
            $options .= "<option value=\"{$task->id}\">{$task->name}</option>";
        }
    
        return "<select class=\"form-control\" id=\"exampleFormControlSelect1\" name=\"task_id\">{$options}</select>";
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
