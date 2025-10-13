<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeePosition;
use App\Models\EmployeePositionRelation;
use App\Models\Hadafstrategy;
use App\Models\Subtask;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeePositionController extends Controller
{
    //
    public function team($id){

        //i want you to check if the use in env is strategy or not if it is strategy you return the team of the employee position with id $id
       $strategyIds = explode(',', env('ADMIN_ID', ''));
            if (in_array(current_user_position()->id, $strategyIds)) {
            // dd('You are in strategy control mode');
            $employees = \App\Models\EmployeePosition::all();
        } else {
            $employees = \App\Models\EmployeePositionRelation::where('parent_id',$id)->get()->pluck('child_id');
            $employees = \App\Models\EmployeePosition::whereIn('id',$employees)->get();
        }
        // dd($employees);
        // dd($employees);
        return View('/employee_positions/team', [
            'employeepositions' =>$employees,
            
        ]);
    }
    public function index()
    {
        //
        // dd(EmployeePosition::with('user')->get());
       return View('/employee_positions/index', [
        'employeepositions' => EmployeePosition::with('user')->get(),

        ]);
    }


    public function top()
    {
       
// Fetch all employee positions
$employee_positions = EmployeePosition::whereNotIn('id', [9999])->get();

$employee_scores = [];

foreach ($employee_positions as $employee_position) {

    // Fetch all subtasks related to this employee

    $subtasks = Subtask::where('user_id', $employee_position->id)->get();
    $total_subtasks = $subtasks->count();
    $total_completed_subtasks = $subtasks->where('percentage', 100)->count();
    $points = 0;

    // Loop through each subtask to calculate points
    foreach ($subtasks as $subtask) {
        if ($subtask->status == 'approved') {
            if ($subtask->done_time <= $subtask->due_time) {
                // Done on time
                $points += 1; // Full point
            } else {
                // Done after due time
                $points += 1; // Half point
            }
        }
        // No points for not approved tasks
    }

    // Calculate the percentage of points relative to the total subtasks
    $percentage = ($total_subtasks > 0) ? ($points / $total_subtasks) * 100 : 0;

    // Store the employee's score in an array
    $employee_scores[] = [
        'employeeid'=> $employee_position->id,
        'employee_position' => $employee_position,
        'percentage' => $percentage,
        'total_subtasks' => $total_subtasks,
        'total_completed_subtasks' => $total_completed_subtasks,
    ];
}

// Sort employees by the percentage in descending order
usort($employee_scores, function ($a, $b) {
    return $b['percentage'] <=> $a['percentage'];
});

// Get the top 5 employees
$top_5_employees = array_slice($employee_scores, 0, 2000);




$current_employee_id = current_user_position()->id;

$current_employee_score = array_filter($employee_scores, function ($employee_score) use ($current_employee_id) {
    return $employee_score['employeeid'] == $current_employee_id;
});

// Since array_filter preserves array keys, you may want to reset the keys
$current_employee_score = array_values($current_employee_score);

// Now you can access the employee_position and percentage
if (!empty($current_employee_score)) {
    $employee_position = $current_employee_score[0]['employee_position'];
    $percentage = floor($current_employee_score[0]['percentage']);

}



// Output the results

//
       

       return View('/employee_positions/top', [
        'top_5_employees' => $top_5_employees,
        'current_employee_score' => $current_employee_score,


        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return View('/employee_positions/create', [
            //'hadafstrategy' => Hadafstrategy::all(),
            'users' => $users,
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
        $name= $request->input('name');
        $employeeposition = new EmployeePosition();
        $employeeposition->name = $name;
        // $hadafstrategy->percentage = 0;
        $employeeposition->user_id = $request->input('user_id');
        $employeeposition->save();
        return back()->with('success', 'تم إضافة الهدف بنجاح');
    }


    public function attach_users($position_id )
    {
        // dd($position_id);
        $employeeposition = EmployeePosition::find($position_id);
        // dd($employeeposition->name);
        return View('/employee_positions/attach_users', [
            'employeeposition' => $employeeposition->name,
            'employee_positions' => EmployeePosition::where('id', '!=', $position_id)->get(),
            'position_id' => $position_id,
        ]);
    }
    public function attach_users_store($position_id, Request $request )
    {
        $parentId = $position_id; // This gets your parent_id from the request

        $options = $request->input('employee_positions'); // This is your array of child_ids from the select input
    
        if (is_array($options)) {

            
           EmployeePositionRelation::where('parent_id', $parentId)->delete();

            // Now, let's create new relations
            foreach ($options as $childId) {
                \App\Models\EmployeePositionRelation::create([
                    'parent_id' => $parentId,
                    'child_id' => $childId,
                ]);
            }

//return back to route with name employeepositions.index
            return redirect()->route('employeepositions.index')->with('success', 'تم إضافة الموظفين بنجاح');
        } else {
            return "No options selected. Maybe try actually selecting something next time?";
        }
    }
}

