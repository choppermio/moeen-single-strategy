<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;

use App\Models\Subtask;
use App\Models\Mubadara;
use Illuminate\Http\Request;
use App\Models\EmployeePosition;
use App\Models\EmployeePositionRelation;
use App\Models\Ticket;
use App\Models\TicketTransition; // Import the TicketTransition class
use App\Models\TaskUserAssignment;
use App\Notifications\NewTicketNotification;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('/subtask/index', [
            'subtasks' => Subtask::all()
        ]);
    }







    public function analystYear($year){
         

        $stumble_subtasks = Subtask::where('status', 'pending')
            ->whereColumn('due_time', '<', 'done_time')
            ->whereYear('start_date', $year) // Filter subtasks with start_date in April
            ->count();

        

        

        $stumble2 = Subtask::where('status', 'pending')
            ->where('due_time', '<', now())
            ->whereNull('done_time')
            ->whereYear('start_date', $year) // Filter subtasks with start_date in April
            ->count();

        $stumble_subtasks += $stumble2;

        $subtasksCount = Subtask::whereYear('start_date', $year)->count(); // All subtasks that started in April
        $currentSubtasks = Subtask::where('status', 'pending')
            ->whereYear('start_date', $year)
            ->count();

            
        $pendingSubtasks = Subtask::where('status', 'pending-approval')
            ->whereYear('start_date', $year)
            ->count();
        $strategyPendingSubtasks = Subtask::where('status', 'strategy-pending-approval')
            ->whereYear('start_date', $year)
            ->count();
        $doneCount = Subtask::where('status', 'approved')
            ->whereYear('start_date', $year)
            ->count();

             return [
                'stumble_subtasks' => $stumble_subtasks,
                'subtasks_count' => $subtasksCount,
                'current_subtasks' => $currentSubtasks,
                'pending_subtasks' => $pendingSubtasks,
                'strategy_pending_subtasks' => $strategyPendingSubtasks,
                'done_count' => $doneCount,
                'total_count' => $stumble_subtasks + $strategyPendingSubtasks + $currentSubtasks + $doneCount // Optionally sum some counts
            ];

    }



     public function analystMonthly($month){
        
       if(isset($_GET['department_id'])){
        $dep = $_GET['department_id'];
        // get all the child_ids from EmployeePositionRelation where parent_id = $dep
        if(isset($_GET['solo'])){
            $child_ids = [$_GET['department_id']];
        }else{
            $child_ids = EmployeePositionRelation::where('parent_id', $dep)->get()->pluck('child_id');
            $child_ids->push(current_user_position()->id);
        }
       //add current_employee_position_id to the child_ids
       
        // $stumble_subtasks = Subtask::where('status', 'pending')
        //     ->whereColumn('due_time', '<', 'done_time')
        //     ->whereMonth('start_date', $month)->whereYear('start_date', date('Y')) // Filter subtasks with start_date in April
        //     ->whereIn('user_id', $child_ids)
        //     ->count();
       }

        $stumble_subtasks = Subtask::where('status', 'pending')
            ->whereColumn('due_time', '<', 'done_time')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y')) // Filter subtasks with start_date in April
            ;

            if(isset($_GET['department_id'])){
                $stumble_subtasks = $stumble_subtasks->whereIn('user_id', $child_ids)->count();
            }else{
                 $stumble_subtasks =isset($_GET['user_id'])? $stumble_subtasks->where('user_id','=',$_GET['user_id'])->count(): $stumble_subtasks->count();
            }

        $stumble2 = Subtask::where('status', 'pending')
            ->where('due_time', '<', now())
            ->whereNull('done_time')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y')) // Filter subtasks with start_date in April
           ;
            
           if(isset($_GET['department_id'])){
            $stumble2 = $stumble2->whereIn('user_id', $child_ids)->count();
        }else{
            $stumble2 =isset($_GET['user_id'])? $stumble2->where('user_id','=',$_GET['user_id'])->count(): $stumble2->count();
        }
        //    $stumble2 =isset($_GET['user_id'])? $stumble2->where('user_id','=',$_GET['user_id'])->count(): $stumble2->count();
        
        $stumble_subtasks += $stumble2;

        $subtasksCount = Subtask::whereMonth('start_date', $month); // All subtasks that started in April
        
        if(isset($_GET['department_id'])){
            $subtasksCount = $subtasksCount->whereIn('user_id', $child_ids)->count();
        }else{
            $subtasksCount =isset($_GET['user_id'])? $subtasksCount->where('user_id','=',$_GET['user_id'])->count(): $subtasksCount->count();
        }
        
        
        $currentSubtasks = Subtask::where('status', 'pending')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))
            ;

           if(isset($_GET['department_id'])){
                $currentSubtasks = $currentSubtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $currentSubtasks =isset($_GET['user_id'])? $currentSubtasks->where('user_id','=',$_GET['user_id'])->count(): $currentSubtasks->count();
            }
        $pendingSubtasks = Subtask::where('status', 'pending-approval')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))
            ;
            if(isset($_GET['department_id'])){
                $pendingSubtasks = $pendingSubtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $pendingSubtasks =isset($_GET['user_id'])? $pendingSubtasks->where('user_id','=',$_GET['user_id'])->count(): $pendingSubtasks->count();
            }

        $strategyPendingSubtasks = Subtask::where('status', 'strategy-pending-approval')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))
            ;

            if(isset($_GET['department_id'])){
                $strategyPendingSubtasks = $strategyPendingSubtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $strategyPendingSubtasks =isset($_GET['user_id'])? $strategyPendingSubtasks->where('user_id','=',$_GET['user_id'])->count(): $strategyPendingSubtasks->count();
            }

            
        $doneCount = Subtask::where('status', 'approved')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))
            ;
            if(isset($_GET['department_id'])){
                $doneCount = $doneCount->whereIn('user_id', $child_ids)->count();
            }else{
                $doneCount =isset($_GET['user_id'])? $doneCount->where('user_id','=',$_GET['user_id'])->count(): $doneCount->count();
            }


            $pendingApprovalCount = Subtask::where('status', 'pending-approval')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))
            ;
            if(isset($_GET['department_id'])){
                $pendingApprovalCount = $pendingApprovalCount->whereIn('user_id', $child_ids)->count();
            }else{
                $pendingApprovalCount =isset($_GET['user_id'])? $pendingApprovalCount->where('user_id','=',$_GET['user_id'])->count(): $pendingApprovalCount->count();
            }



             return [
                'stumble_subtasks' => $stumble_subtasks,
                'subtasks_count' => $subtasksCount,
                'current_subtasks' => $currentSubtasks,
                'pending_subtasks' => $currentSubtasks,
                'strategy_pending_subtasks' => $strategyPendingSubtasks,
                'done_count' => $doneCount,
                'pending_approval_count' => $pendingApprovalCount,
                // 'total_count' =>$subtasksCount
                'total_count' => $stumble_subtasks + $strategyPendingSubtasks + $currentSubtasks + $doneCount // Optionally sum some counts
            ];

    }





    public function analystYearUser($year){
        
        if(isset($_GET['department_id'])){
            $dep = $_GET['department_id'];
            // get all the child_ids from EmployeePositionRelation where parent_id = $dep

            if(isset($_GET['solo'])){
                $child_ids = [$_GET['department_id']];
            }else{
                $child_ids = EmployeePositionRelation::where('parent_id', $dep)->get()->pluck('child_id');
                $child_ids->push(current_user_position()->id);
            }
            // $stumble_subtasks = Subtask::where('status', 'pending')
            //     ->whereColumn('due_time', '<', 'done_time')
            //     ->whereMonth('start_date', $month)->whereYear('start_date', date('Y')) // Filter subtasks with start_date in April
            //     ->whereIn('user_id', $child_ids)
            //     ->count();
           }
    

        $stumble_subtasks = Subtask::where('status', 'pending')
            ->whereColumn('due_time', '<', 'done_time')->
            where( DB::raw('YEAR(start_date)'), '=', $year ) // Filter subtasks with start_date in April
            ;

            
            if(isset($_GET['department_id'])){
                $stumble_subtasks = $stumble_subtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $stumble_subtasks =isset($_GET['user_id'])? $stumble_subtasks->where('user_id','=',$_GET['user_id'])->count(): $stumble_subtasks->count();
            }
        

        $stumble2 = Subtask::where('status', 'pending')
            ->where('due_time', '<', now())
            ->whereNull('done_time')
            ->where( DB::raw('YEAR(start_date)'), '=', $year) // Filter subtasks with start_date in April
            ;

            if(isset($_GET['department_id'])){
                $stumble2 = $stumble2->whereIn('user_id', $child_ids)->count();
            }else{
                $stumble2 =isset($_GET['user_id'])? $stumble2->where('user_id','=',$_GET['user_id'])->count(): $stumble2->count();
            }
        $stumble_subtasks += $stumble2;

        $subtasksCount = Subtask::where( DB::raw('YEAR(start_date)'), '=', $year ); // All subtasks that started in April

        if(isset($_GET['department_id'])){
            $subtasksCount = $subtasksCount->whereIn('user_id', $child_ids)->count();
        }else{
            $subtasksCount =isset($_GET['user_id'])? $subtasksCount->where('user_id','=',$_GET['user_id'])->count(): $subtasksCount->count();
        }


       


            $currentSubtasks = Subtask::where('status', 'pending')
            ->where( DB::raw('YEAR(start_date)'), '=', $year )
            ;

            if(isset($_GET['department_id'])){
                $currentSubtasks = $currentSubtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $currentSubtasks =isset($_GET['user_id'])? $currentSubtasks->where('user_id','=',$_GET['user_id'])->count(): $currentSubtasks->count();
            }


            
           
        $pendingSubtasks = Subtask::where('status', 'pending-approval')
            ->where( DB::raw('YEAR(start_date)'), '=', $year )
            ;

            if(isset($_GET['department_id'])){
                $pendingSubtasks = $pendingSubtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $pendingSubtasks =isset($_GET['user_id'])? $pendingSubtasks->where('user_id','=',$_GET['user_id'])->count(): $pendingSubtasks->count();
            }
        //    dd( $pendingSubtasks);

        $strategyPendingSubtasks = Subtask::where('status', 'strategy-pending-approval')
            ->where( DB::raw('YEAR(start_date)'), '=', $year )
           ;

            if(isset($_GET['department_id'])){
                $strategyPendingSubtasks = $strategyPendingSubtasks->whereIn('user_id', $child_ids)->count();
            }else{
                $strategyPendingSubtasks =isset($_GET['user_id'])? $strategyPendingSubtasks->where('user_id','=',$_GET['user_id'])->count(): $strategyPendingSubtasks->count();
            }


        $doneCount = Subtask::where('status', 'approved')
            ->where( DB::raw('YEAR(start_date)'), '=', $year )
            ;

            if(isset($_GET['department_id'])){
                $doneCount = $doneCount->whereIn('user_id', $child_ids)->count();
            }else{
                $doneCount =isset($_GET['user_id'])? $doneCount->where('user_id','=',$_GET['user_id'])->count(): $doneCount->count();
            }



            $pendingApprovalCount = Subtask::where('status', 'pending-approval')
            ->where( DB::raw('YEAR(start_date)'), '=', $year )
            ;

            if(isset($_GET['department_id'])){
                $pendingApprovalCount = $pendingApprovalCount->whereIn('user_id', $child_ids)->count();
            }else{
                $pendingApprovalCount =isset($_GET['user_id'])? $pendingApprovalCount->where('user_id','=',$_GET['user_id'])->count(): $pendingApprovalCount->count();
            }
            // dd($pendingSubtasks);
// dd($pendingApprovalCount);
             return [
                'stumble_subtasks' => $stumble_subtasks,
                'subtasks_count' => $subtasksCount,
                'current_subtasks' => $currentSubtasks,
                'pending_subtasks' => $pendingSubtasks,
                'strategy_pending_subtasks' => $strategyPendingSubtasks,
                'done_count' => $doneCount,
                'pending_approval_count' => $pendingApprovalCount,
                'total_count' => $stumble_subtasks + $strategyPendingSubtasks + $currentSubtasks + $doneCount+$pendingSubtasks // Optionally sum some counts
            ];

    }



     public function analystMonthlyUser($month){
        
       

        $stumble_subtasks = Subtask::where('status', 'pending')
            ->whereColumn('due_time', '<', 'done_time')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id']) // Filter subtasks with start_date in April
            ->count();

        $stumble2 = Subtask::where('status', 'pending')
            ->where('due_time', '<', now())
            ->whereNull('done_time')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id']) // Filter subtasks with start_date in April
            ->count();

        $stumble_subtasks += $stumble2;

        $subtasksCount = Subtask::whereMonth('start_date', $month)->where('user_id','=',$_GET['user_id'])->count(); // All subtasks that started in April
        $currentSubtasks = Subtask::where('status', 'pending')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id'])
            ->count();
        $pendingSubtasks = Subtask::where('status', 'pending-approval')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id'])
            ->count();
        $strategyPendingSubtasks = Subtask::where('status', 'strategy-pending-approval')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id'])
            ->count();
        $doneCount = Subtask::where('status', 'approved')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id'])
            ->count();

            $pendingApprovalCount = Subtask::where('status', 'pending-approval')
            ->whereMonth('start_date', $month)->whereYear('start_date', date('Y'))->where('user_id','=',$_GET['user_id'])
            ->count();



            

            if(isset($_GET['department_id'])){
                $pendingApprovalCount = $pendingApprovalCount->whereIn('user_id', $child_ids)->count();
            }else{
                $pendingApprovalCount =isset($_GET['user_id'])? $pendingApprovalCount->where('user_id','=',$_GET['user_id'])->count(): $pendingApprovalCount->count();
            }

             return [
                'stumble_subtasks' => $stumble_subtasks,
                'subtasks_count' => $subtasksCount,
                'current_subtasks' => $currentSubtasks,
                'pending_subtasks' => $currentSubtasks,
                'strategy_pending_subtasks' => $strategyPendingSubtasks,
                'done_count' => $doneCount,
                'total_count' => $stumble_subtasks + $strategyPendingSubtasks + $currentSubtasks + $doneCount // Optionally sum some counts
            ];

    }


    public function analyst(Request $request){
        $months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
         
        $dataMonth1= self::analystMonthly(1);
        // dd( $dataMonth1);
        $dataMonth2= self::analystMonthly(2);
        $dataMonth3= self::analystMonthly(3);
        $dataMonth4= self::analystMonthly(4);
        // dd($dataMonth4);
        $dataMonth5= self::analystMonthly(5);
        $dataMonth6= self::analystMonthly(6);
        $dataMonth7= self::analystMonthly(7);
        $dataMonth8= self::analystMonthly(8);
        $dataMonth9= self::analystMonthly(9);
        $dataMonth10= self::analystMonthly(10);
        $dataMonth11= self::analystMonthly(11);
        $dataMonth12= self::analystMonthly(12);

    
        $dataeverymonthDoneSubtaks = [
            $dataMonth1['done_count'],
            $dataMonth2['done_count'],
            $dataMonth3['done_count'],
            $dataMonth4['done_count'],
            $dataMonth5['done_count'],
            $dataMonth6['done_count'],
            $dataMonth7['done_count'],
            $dataMonth8['done_count'],
            $dataMonth9['done_count'],
            $dataMonth10['done_count'],
            $dataMonth11['done_count'],
            $dataMonth12['done_count']
        ];
        
         // Data set 1
        //  dd($dataMonth4['pending_subtasks']);
         $dataeverymonthPendingSubtasks = [
            $dataMonth1['pending_subtasks'],
            $dataMonth2['pending_subtasks'],
            $dataMonth3['pending_subtasks'],
            $dataMonth4['pending_subtasks'],
            $dataMonth5['pending_subtasks'],
            $dataMonth6['pending_subtasks'],
            $dataMonth7['pending_subtasks'],
            $dataMonth8['pending_subtasks'],
            $dataMonth9['pending_subtasks'],
            $dataMonth10['pending_subtasks'],
            $dataMonth11['pending_subtasks'],
            $dataMonth12['pending_subtasks']
        ];
        $dataeverymonthStumbleSubtasks = [
            $dataMonth1['stumble_subtasks'],
            $dataMonth2['stumble_subtasks'],
            $dataMonth3['stumble_subtasks'],
            $dataMonth4['stumble_subtasks'],
            $dataMonth5['stumble_subtasks'],
            $dataMonth6['stumble_subtasks'],
            $dataMonth7['stumble_subtasks'],
            $dataMonth8['stumble_subtasks'],
            $dataMonth9['stumble_subtasks'],
            $dataMonth10['stumble_subtasks'],
            $dataMonth11['stumble_subtasks'],
            $dataMonth12['stumble_subtasks']
        ];

        
        $dataeverymonthStrategyPendingSubtasks = [
            $dataMonth1['strategy_pending_subtasks'],
            $dataMonth2['strategy_pending_subtasks'],
            $dataMonth3['strategy_pending_subtasks'],
            $dataMonth4['strategy_pending_subtasks'],
            $dataMonth5['strategy_pending_subtasks'],
            $dataMonth6['strategy_pending_subtasks'],
            $dataMonth7['strategy_pending_subtasks'],
            $dataMonth8['strategy_pending_subtasks'],
            $dataMonth9['strategy_pending_subtasks'],
            $dataMonth10['strategy_pending_subtasks'],
            $dataMonth11['strategy_pending_subtasks'],
            $dataMonth12['strategy_pending_subtasks']
        ];
         // Data set 3

$type=$_GET['type'];
$id = $_GET['id'];
if($type=='month' && isset($_GET['user_id'])){
    $data= self::analystMonthly(date($id));
}
elseif($type=='month'){
    $data= self::analystMonthly(date($id));
}elseif($type=='year' && isset($_GET['user_id'])){
    $data= self::analystYearUser(date($id));
}elseif($type=='year' ){
    $data= self::analystYearUser(date($id));   
}

        return View('/subtask/analyst', [
            'data'=> [$data['stumble_subtasks'], $data['strategy_pending_subtasks']+$data['pending_approval_count'], $data['current_subtasks'], $data['done_count']], // Example data
            'subtasks_count' => $data['subtasks_count'],
            'current_subtasks' => $data['current_subtasks'],
            'pending_subtasks' => $data['pending_subtasks'],
            'pending_approval_subtasks'=> $data['pending_approval_count'],
            'strategy_pending_subtasks' => $data['strategy_pending_subtasks'],
            'stumble_subtasks' => $data['stumble_subtasks'],
            'done_subtasks' => $data['done_count'],
            'months' => $months,
            'monthlyDone' => $dataeverymonthDoneSubtaks,
            'monthlyPending' => $dataeverymonthPendingSubtasks,
            'monthlyStumble' => $dataeverymonthStumbleSubtasks,
            'monthlyStrategyPending' => $dataeverymonthStrategyPendingSubtasks,

            
           
            
        ]);

    }

   

    public function mysubtaskscalendar()
    {
        $user = (int)isset($_GET['user']) ? $_GET['user'] :current_user_position()->id;
        $subtasks = Subtask::where('user_id',  $user)->get();
        // dd( $subtasks);


        $calendar_data = $subtasks->map(function($subtask) {
            return [
                'title' => $subtask->name, // replace 'name' with the actual field name for the event title
                'start' => $subtask->start_date, // replace 'start_date' with the actual field name for the event start date
                'end' => $subtask->end_date // replace 'end_date' with the actual field name for the event end date
            ];
        });

        return View('/subtask/mysubtaskscalendar', [
            'subtasks' => Subtask::where('user_id', $user)->get(),
            'calendar_data' => $calendar_data
        ]);
    }

    public function mysubtasks()
    {
        if(isset($_GET['show-as-admin']) && isset($_GET['id'])){
            $parent_check = EmployeePositionRelation::where('child_id',$_GET['id'])->first();
            // Check if current_user_position()->id is in the comma-separated env STRATEGY_ID
            $strategyIds = explode(',', env('ADMIN_ID', ''));
            if (in_array(current_user_position()->id, $strategyIds)) {
            $user_id = (int)$_GET['id'];
            
            $current_user  = $_GET['id'];
        }else{
            die('error');
        }

         $user_id = EmployeePosition::where('id',$user_id)->first()->id;
        $employee_position = EmployeePosition::where('id',$current_user)->first();


        }else{
            $user_id = auth()->user()->id;
            $current_user  = auth()->user()->id;
              $user_id = EmployeePosition::where('user_id',$user_id)->first()->id;
        $employee_position = EmployeePosition::where('user_id',$current_user)->first();
        }
      
        // dd($employee_position);
        $children_employee_positions = EmployeePositionRelation::where('parent_id',$employee_position->id)->get()->pluck('childPosition');
    //    dd($children_employee_positions);
        // dd(Subtask::where('user_id', $user_id) ->where('status', [ 'pending-approval'])->get());
    //   dd(Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->get());
        return View('/subtask/mysubtasks', [
            'subtasks' => Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->get(),
            
            'completed_subtasks' => Subtask::where('user_id',$user_id)->where('percentage', 100)->get(),
            'pending_subtasks' => Subtask::where('user_id', $user_id) ->where('status', [ 'pending-approval'])->get(),
            'user_id' => $user_id,
            'children_employee_positions' => $children_employee_positions,
        ]);
    }


    
    public function settomyteam()
    {
        $current_user  = auth()->user()->id;
        $employee_position = EmployeePosition::where('user_id',$current_user)->first();
        
        // Get all employee positions for unrestricted selection
        $all_employee_positions = EmployeePosition::with('user')->get();
        
        return View('/subtask/settomyteam', [
            'mubadaras' => Mubadara::where('user_id',$employee_position->id)->where('percentage', '!=', 101)->get(),
            'all_employees' => $all_employee_positions,
        ]);
    }
    
    
 
  function evidence(Request $request)
    {

        
        $user_id = auth()->id(); // remember to call the method, not hug the property

// dd($user_id); // at least you got the dump part right

        // dd($user_id);
        $subtaskid = $request->subtaskid;
        
        $subtask = Subtask::find($subtaskid);
        $imagess = $subtask->getMedia('images');
        // dd($imagess);
        return View('/subtask/evidence', [
            'imagess' => $imagess,
            'subtaskid' => $subtaskid,
        ]);
    }


    public function settomyteamform(Request $request)
    {
        $user_ids = $request->input('user_ids', []);
        
        if (empty($user_ids)) {
            return redirect()->back()->with('error', 'يجب اختيار موظف واحد على الأقل');
        }

        // Validate that all employee positions exist
        foreach ($user_ids as $user_id) {
            $employee_u = EmployeePosition::where('id', $user_id)->count();
            if($employee_u == 0){
                return redirect()->back()->with('error', 'لايوجد موظف بهذه البيانات: ' . $user_id);
            }
        }

        if($request->typo == 'task'){
            $task = Task::find($request->input('subtaskid'));
            // dd($task);
            if (!$task) {
                return redirect()->back()->with('error', 'المهمة غير موجودة');
            }

            // Clear existing assignments for this task
            TaskUserAssignment::where('task_id', $task->id)->where('type', 'task')->delete();
            
            // Create new assignments for each selected user
            foreach ($user_ids as $user_id) {
                TaskUserAssignment::create([
                    'task_id' => $task->id,
                    'employee_position_id' => $user_id,
                    'type' => 'task'
                ]);
            }

            // Also update the main task assignment to the first selected user for backward compatibility
            $task->user_id = $user_ids[0];
            $task->save();

        } else {
            $subtask = Subtask::find($request->input('subtaskid'));
            if (!$subtask) {
                return redirect()->back()->with('error', 'المهمة الفرعية غير موجودة');
            }

            // Clear existing assignments for this subtask
            TaskUserAssignment::where('subtask_id', $subtask->id)->where('type', 'subtask')->delete();
            
            // Create new assignments for each selected user
            foreach ($user_ids as $user_id) {
                TaskUserAssignment::create([
                    'subtask_id' => $subtask->id,
                    'employee_position_id' => $user_id,
                    'type' => 'subtask'
                ]);
            }

            // Update the main subtask assignment to the first selected user for backward compatibility
            $subtask->user_id = $user_ids[0];
            $subtask->transfered = 1;
            $subtask->parent_user_id = EmployeePosition::where('user_id', auth()->id())->first()->id;
            $subtask->save();
        }

        return redirect()->route('subtask.settomyteam')->with('success', 'تم إسناد المهمة للموظفين المختارين بنجاح');
    }
    
    /**
     * Get assignments for a specific task or subtask
     */
    public function getAssignments(Request $request)
    {
        $type = $request->input('type'); // 'task' or 'subtask'
        $id = $request->input('id');
        
        if ($type === 'task') {
            $assignments = TaskUserAssignment::getAssignedUsersForTask($id);
        } else {
            $assignments = TaskUserAssignment::getAssignedUsersForSubtask($id);
        }
        
        return response()->json($assignments);
    }
    
    /**
     * Show assignment statistics
     */
    public function assignmentStats()
    {
        $stats = [];
        
        // Get total tasks and subtasks
        $totalTasks = Task::count();
        $totalSubtasks = Subtask::count();
        
        // Get tasks and subtasks with multiple assignments
        $multiAssignedTasks = TaskUserAssignment::where('type', 'task')
            ->select('task_id')
            ->groupBy('task_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();
            
        $multiAssignedSubtasks = TaskUserAssignment::where('type', 'subtask')
            ->select('subtask_id')
            ->groupBy('subtask_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();
        
        // Get unassigned tasks and subtasks
        $unassignedTasks = $totalTasks - TaskUserAssignment::where('type', 'task')->distinct('task_id')->count();
        $unassignedSubtasks = $totalSubtasks - TaskUserAssignment::where('type', 'subtask')->distinct('subtask_id')->count();
        
        $stats = [
            'total_tasks' => $totalTasks,
            'total_subtasks' => $totalSubtasks,
            'multi_assigned_tasks' => $multiAssignedTasks,
            'multi_assigned_subtasks' => $multiAssignedSubtasks,
            'unassigned_tasks' => $unassignedTasks,
            'unassigned_subtasks' => $unassignedSubtasks,
        ];
        
        return view('subtask.assignment-stats', compact('stats'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return View('/subtask/create',[
            'tasks' => Task::all(),
            


        ]);
    }
    public function add()
    {
        
        $tasks = Task::where('user_id',EmployeePosition::where('user_id',auth()->id())->first()->id)->get();
        return View('/subtask/add', compact('tasks'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        //if id is admin
        if(auth()->id() == 1){
            $mubadara_id = Task::where('id',$request->input('task'))->first()->parent_id;
           
            $mubadara_user_id = Mubadara::where('id',$mubadara_id)->first()->user_id;
            // dd($mubadara_user_id);
            $employee_id=  EmployeePosition::where('user_id',$mubadara_user_id)->first()->id;
        }else{
        $employee_id=  EmployeePosition::where('user_id',auth()->id())->first()->id;
    }
        $employee_parent_id=  EmployeePositionRelation::where('child_id',$employee_id)->first()->parent_id;
        // dd($employee_parent_id);
        $subtask = Subtask::create([
            'name' => $request->input('name'),
            'percentage' => 0,
            'parent_id' => $request->input('task'),
            'done' => 0,
            'user_id'=> $employee_id,
            'parent_user_id'=> $employee_parent_id,
        ]);
        calculatePercentages();

        return redirect()->route('subtask.mysubtasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function show(Subtask $subtask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
//     public function subtaskattachment(Subtask $subtask, Request $request)
//     {
//         // Find the subtask based on the request input
//         $subtask = Subtask::find($request->input('subtask'));
    
//         // Check if the request has files
//         if ($request->hasFile('files')) {
//             foreach ($request->file('files') as $file) {
//                 // Add each file to the media collection with a unique filename
//                 $subtask->addMedia($file)
//                     ->usingFileName(uniqid() . '_' . $file->getClientOriginalName())
//                     ->toMediaCollection('images', 'public_uploads');
//             }
            
//             // Update the subtask status
//             $subtask->status = 'pending-approval';
            
//             if ($subtask->getMedia()->isEmpty()) {
//                 $subtask->done_time = now(); 
//             }
//             $subtask->save();
//         }
    
//         try{
//             $ticket = Ticket::where('id', $subtask->ticket_id)->first();
//             $ticketTransition = TicketTransition::create([
//                 'ticket_id' =>   $ticket->id, 
//                 'from_state' => current_user_position()->id,
//                 'to_state' =>001,
//                 'date' => date('Y-m-d H:i:s'),
//                 'status' => 'attachment-added',
//             ]);
    
//         }catch(\Exception $e){
//             dd($e);
//         }

        
// $employee_parent_id = EmployeePositionRelation::where('child_id', current_user_position()->id)->first()->parent_id;
//         $employee = EmployeePosition::find($employee_parent_id);

//         // Check if the employee exists and has an associated user
//         if ($employee && $employee->user) {
//             $email = $employee->user->email;
    
//             // Send the email if not in local environment
//             if (env('ENVO') !== 'local') {
//                 Mail::raw(
//                     'تم رفع شاهد لمهمة' . $ticket->name,
//                     function ($message) use ($email) {
//                         $message->to($email)
//                                 ->subject('تم رفع شواهد تحتاج ان يتم الموافقة عليها');
//                     }
//                 );
//             }
//         }




//         // Redirect to the mysubtasks route
//         return redirect()->route('subtask.mysubtasks');
//     }




public function subtaskattachment(Subtask $subtask, Request $request)
{
    // Find the subtask based on the request input
    $subtask = Subtask::find($request->input('subtask'));

    // Check if the request has files
    if ($request->hasFile('files')) {
        $files = $request->file('files');
        $notes = $request->input('notes', []); // Get notes array
        
        foreach ($files as $index => $file) {
            // Sanitize the file name: allow Arabic, alphanumeric, hyphen, underscore, and dot
            $originalFileName = $file->getClientOriginalName();
            $sanitizedFileName = preg_replace('/[^\p{Arabic}A-Za-z0-9\-_\.]/u', '_', $originalFileName);

            // Add each file to the media collection with a unique filename and note as custom property
            $mediaItem = $subtask->addMedia($file)
                ->usingFileName(uniqid() . '_' . $sanitizedFileName)
                ->toMediaCollection('images', 'public_uploads');
            
            // Add note as custom property if provided
            if (isset($notes[$index]) && !empty($notes[$index])) {
                $mediaItem->setCustomProperty('note', $notes[$index]);
                $mediaItem->save();
            }
        }
        
        // Update the subtask status
        $subtask->status = 'pending-approval';
        
        if ($subtask->getMedia()->isEmpty()) {
            $subtask->done_time = now(); 
        }
        $subtask->save();
    }

    try {
        $ticket = Ticket::where('id', $subtask->ticket_id)->first();
        $ticketTransition = TicketTransition::create([
            'ticket_id' => $ticket->id, 
            'from_state' => current_user_position()->id,
            'to_state' => 001,
            'date' => date('Y-m-d H:i:s'),
            'status' => 'attachment-added',
        ]);
    } catch (\Exception $e) {
        dd($e);
    }

    $employee_parent_id = EmployeePositionRelation::where('child_id', current_user_position()->id)->first()->parent_id;
    $employee = EmployeePosition::find($employee_parent_id);

    // Check if the employee exists and has an associated user
    if ($employee && $employee->user) {
        $email = $employee->user->email;

        // Send notification email to supervisor if not in local environment
        if (env('ENVO') !== 'local') {
            try {
            Mail::raw(
                "تم رفع شاهد جديد للمهمة: {$ticket->name}\n\nيرجى مراجعة الشواهد والموافقة عليها من خلال النظام.",
                function ($message) use ($email) {
                $message->to($email)
                    ->subject('إشعار: شواهد جديدة تحتاج للموافقة')
                    ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );            } catch (\Exception $e) {
            Log::error('Failed to send notification email: ' . $e->getMessage());
            }
        }
    }

    // Redirect to the mysubtasks route
    return redirect()->route('subtask.mysubtasks');
}

    
    public function edit(Subtask $subtask,Request $request)
    {
        // $subtask = Subtask::find(1);
        // if ($request->hasFile('image')) {
        //     // $subtask->clearMediaCollection('images');
        //     $subtask->addMediaFromRequest('image')->toMediaCollection('images');
        // }
        // dd($subtask->id);
        // dd(Subtas    k::where('id',$subtask->id)->first());
        return View('/subtask/edit',[
            'subtask' => Subtask::where('id',$subtask->id)->first(),
            'tasks' => Task::all(),
            


        ]);
    }


    public function sendNotification()
    {
        try {
            Mail::to('it@qimam.org.sa')->send(new NewTicketNotification());
            return 'Notification sent!';        } catch (\Exception $e) {
            Log::error('Failed to send notification email: ' . $e->getMessage());
            return 'Notification failed to send, but system continues.';
        }
    }



    public function approval()
    {
        // dd(auth()->id());
        // dd(EmployeePosition::where('id',auth()->id())->first()->id);
        // dd(Subtask::where('status','=','pending-approval')->where('parent_user_id',EmployeePosition::where('id',auth()->id())->first()->id)->get());
        // dd(Subtask::where('status','=','pending-approval')->where('parent_user_id',EmployeePosition::where('id',auth()->id())->first()->id)->get());
        // dd(Subtask::where('status','=','pending-approval')->get());
        $employeePositionId = EmployeePosition::where('id', auth()->id())->first()->id ?? null;
        $subtasks = Subtask::whereIn('status', ['rejected', 'pending-approval'])
        ->where('parent_user_id', $employeePositionId)
        ->get();
        return View('/subtask/approval', [
            'subtasks' =>  $subtasks,
        ]);    
    }

    public function strategyEmployeeApproval()
    {
        // dd(Subtask::where('status','=','strategy-pending-approval')->get());
        //dd(Subtask::where('status','=','strategy-pending-approval')->get());
        $ticket_ids_rejected = TicketTransition::where('status', 'strategy-rejected')->distinct()->pluck('ticket_id');
        $subtask_rejected = Subtask::whereIn('ticket_id', $ticket_ids_rejected)->get();
        // dd($subtask_rejected);

        $ticket_ids_approved = TicketTransition::where('status', 'strategy-approved')->distinct()->pluck('ticket_id');
        $subtask_approved = Subtask::whereIn('ticket_id', $ticket_ids_approved)->get();


        return View('/subtask/strategyEmployeeApproval', [
            'subtasks' => Subtask::where('status','=','strategy-pending-approval')->get(),
            'subtasks_rejected' => $subtask_rejected,
            'subtasks_approved' => $subtask_approved,
        ]);    
    }


    public function status(Request $request)
    {
        // dd('here');
        // dd($request->all());

        if($request->status == 'rejected'){
            $subtask = Subtask::find($request->input('taskid'));
            $subtask->status = 'rejected';
            $subtask->notes = $request->input('notes');
            $subtask->save();

            try {
            $ticketTransition = TicketTransition::create([
                'ticket_id' =>  Ticket::where('id', $subtask->ticket_id)->first()->id, 

                
                'from_state' => current_user_position()->id,
                'to_state' => EmployeePosition::where('user_id', $subtask->user_id)->first()->id,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'rejected',
            ]);
            } catch (\Throwable $e) {
                    dd('Error creating ticket transition: ' . $e->getMessage());

            }


            $employee = EmployeePosition::where('id', $subtask->user_id)->first();
    if ($employee && $employee->user) {
        $email = $employee->user->email;

        // Send the email if not in local environment
        if (env('ENVO') !== 'local') {
            try {
            Mail::raw(
                "تم رفض الشاهد المرفوع للمهمة: {$subtask->name}\n\nالسبب: {$request->input('notes')}\n\nيرجى مراجعة الملاحظات وإعادة رفع الشاهد مع التصحيحات المطلوبة.",
                function ($message) use ($email) {
                $message->to($email)
                    ->subject('إشعار: تم رفض الشاهد - مطلوب إعادة المراجعة')
                    ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );            } catch (\Exception $e) {
            Log::error('Failed to send rejection notification email: ' . $e->getMessage());
            }
        }
    }

            
        }else{
//dd($request->all());
            $subtask = Subtask::find($request->input('taskid'));
           // $subtask->notes = '';
        $subtask->done = $request->input('task_status');
        $subtask->status = 'strategy-pending-approval';

$ticket = Ticket::where('id', $subtask->ticket_id)->first();
        try{
            $ticket = Ticket::where('id', $subtask->ticket_id)->first();
            $ticketTransition = TicketTransition::create([
                'ticket_id' =>  $ticket->id, 
                'from_state' => current_user_position()->id,
                'to_state' =>001,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'strategy-pending-approval',
            ]);
    
        }catch(\Exception $e){
            dd($e);
        }


        if($request->input('task_status') == 1)
        	$subtask->percentage = 100;
        elseif($request->input('task_status') == 0){
            	$subtask->percentage = 0;
        }else{
        	$subtask->percentage = 50;
        }
        $percentage = $request->input('percentage');
    //   dd($request->input('percentage'));
        $subtask->percentage = $request->input('percentage');
        // $subtask->percentage = $request->input('task_status');
        $subtask->save();


        
    // Send notification email to user about task approval
    $employee = EmployeePosition::where('id', $subtask->user_id)->first();
    if ($employee && $employee->user) {
        $email = $employee->user->email;

        // Send the email if not in local environment
        if (env('ENVO') !== 'local') {
            try {
                Mail::raw(
                    "تم الموافقة على الشاهد المرفوع للمهمة: {$subtask->name}\n\nالحالة الحالية: تم إحالة المهمة للموافقة النهائية\n\nيرجى متابعة النظام لأي تحديثات أخرى.",
                    function ($message) use ($email) {
                        $message->to($email)
                                ->subject('إشعار: تم الموافقة على الشاهد - في انتظار الموافقة النهائية')
                                ->from(config('mail.from.address'), config('mail.from.name'));
                    }
                );            } catch (\Exception $e) {
                Log::error('Failed to send task approval notification email: ' . $e->getMessage());
            }
        }
    }

    $employee = EmployeePosition::where('id', $subtask->user_id)->first();
if ($employee && $employee->user) {
    $email = $employee->user->email;

    // Add additional email
    // $additionalEmail = 'governance@qimam.org.sa';
    $strategyemail = \App\Models\EmployeePosition::where('id', env('STRATEGY_CONTROL_ID'))->first();    $additionalEmail = \App\Models\User::where('id', $strategyemail->user_id)->first()->email;
    if (env('ENVO') !== 'local') {
        try {
            Mail::raw(
                'تم تغيير حالة الشاهد للمهمة : ' . $subtask->name . ' الى ' . $request->status,
                function ($message) use ($email, $additionalEmail) {
                    $message->to([$email, $additionalEmail])
                            ->subject('تم تغيير حالة الشاهد للمهمة ');
                }
            );        } catch (\Exception $e) {
            Log::error('Failed to send status change notification email: ' . $e->getMessage());
        }
    }
}



        calculatePercentages();

    }
    // calculatePercentages();

        return redirect()->route('subtask.approval');
    }




    
    public function statusStrategy(Request $request)
    {
        // dd('here');

        if($request->status == 'rejected'){
            $subtask = Subtask::find($request->input('taskid'));
            $subtask->status = 'rejected';
            $subtask->notes = $request->input('notes');

            $subtask->percentage = 0;
            $subtask->save();



            try{
                $ticket = Ticket::where('id', $subtask->ticket_id)->first();
                $ticketTransition = TicketTransition::create([
                    'ticket_id' =>   $ticket->id, 
                    'from_state' => 001,
                    'to_state' => $subtask->user_id,
                    'date' => date('Y-m-d H:i:s'),
                    'status' => 'strategy-rejected',
                ]);
        
            }catch(\Exception $e){
                dd($e);
            }

        }else{
        $subtask = Subtask::find($request->input('taskid'));
        $subtask->notes = '';
        // $subtask->done_time = now();

        $subtask->done = 1;
        $subtask->status = 'approved';
        // if($request->input('task_status') == 1)
        // 	$subtask->percentage = 100;
        // elseif($request->input('task_status') == 0){
        //     	$subtask->percentage = 0;
        // }else{
        // 	$subtask->percentage = 50;
        // }

        $subtask->finished_user_id = $subtask->user_id; 
        // $subtask->percentage = $request->input('task_status');
        $subtask->save();

        try{
            $ticket = Ticket::where('id', $subtask->ticket_id)->first();
            $ticketTransition = TicketTransition::create([
                'ticket_id' =>   $ticket->id, 
                'from_state' => 001,
                'to_state' => $subtask->user_id,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'strategy-approved',
            ]);
    
        }catch(\Exception $e){
            dd($e);
        }


        // calculatePercentages();

    }

    $employee = EmployeePosition::where('id', $subtask->user_id)->first();
    if ($employee && $employee->user) {
        $email = $employee->user->email;        // Send the email if not in local environment
        if (env('ENVO') !== 'local') {
            try {
                Mail::raw(
                    'تم تغيير حالة الشاهد للمهمة : ' . $subtask->name . ' الى ' . $request->status,
                    function ($message) use ($email) {
                        $message->to($email)
                                ->subject('تم تغيير حالة الشاهد للمهمة ');
                    }
                );            } catch (\Exception $e) {
                Log::error('Failed to send task status notification email: ' . $e->getMessage());
            }
        }
    }

    
        calculatePercentages();

        return redirect()->route('subtask.strategyEmployeeApproval');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subtask $subtask)
{
   
//    dd($request->parent_id);
    // dd('d');
    // Step 1: Validate the request
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'parent_id' => 'required',
        // Add other fields as necessary
    ]);

    // Step 2: Update the model
    $subtask->update($validatedData);

    // Step 3: Optionally, handle additional operations like file uploads or complex manipulations

    // Step 4: Return a response, e.g., redirect back or to another page with a success message
    return redirect()->route('subtask.index')->with('success', 'Subtask updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
    }

    public function destroyattachement(Request $request){
        $subtask = Subtask::find($request->input('subtask'));

$mediaItem = $subtask->getMedia('images')->find($request->input('id'));
if ($mediaItem) {
    $mediaItem->delete();
}
       
       
        
        return redirect()->back();
          }
    //create method that change the task_id in subtask model and then change the task_id in ticket model where id = subtask ticket_id
    public function changeTask(Request $request)
    {
        $subtaskId = $request->input('subtask_id');
        $taskId = $request->input('task_id');

        if (!$subtaskId || !$taskId) {
            return response()->json(['success' => false, 'message' => 'Missing parameters'], 400);
        }

        $subtask = Subtask::find($subtaskId);
        if (!$subtask) {
            return response()->json(['success' => false, 'message' => 'Subtask not found'], 404);
        }

        try {
            $subtask->parent_id = $taskId;
            $subtask->save();

            // change the task_id in ticket model where id = subtask ticket_id
            if ($subtask->ticket_id) {
                $ticket = Ticket::find($subtask->ticket_id);
                if ($ticket) {
                    $ticket->task_id = $taskId;
                    $ticket->save();
                }
            }

            // return updated task info so the UI can update without reload
            $task = Task::find($taskId);
            $taskName = $task ? $task->name : null;
            $taskOwnerName = null;
            if ($task && $task->user_id) {
                $owner = EmployeePosition::where('id', $task->user_id)->first();
                $taskOwnerName = $owner ? $owner->name : null;
            }

            return response()->json([
                'success' => true,
                'task_id' => $taskId,
                'task_name' => $taskName,
                'task_owner_name' => $taskOwnerName,
            ]);
        } catch (\Exception $e) {
            Log::error('changeTask error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /**
     * Update subtask percentage via AJAX
     */
    public function updatePercentage(Request $request)
    {
        $subtaskId = $request->input('subtask_id');
        $percentage = $request->input('percentage');

        if (!$subtaskId || !is_numeric($percentage)) {
            return response()->json(['success' => false, 'message' => 'Invalid parameters'], 400);
        }

        $percentage = (int)$percentage;
        if ($percentage < 0) $percentage = 0;
        if ($percentage > 100) $percentage = 100;

        $subtask = Subtask::find($subtaskId);
        if (!$subtask) {
            return response()->json(['success' => false, 'message' => 'Subtask not found'], 404);
        }

        try {
            $subtask->percentage = $percentage;
            $subtask->save();

            // Recalculate any aggregate percentages if you have such function
            if (function_exists('calculatePercentages')) {
                calculatePercentages();
            }

            return response()->json(['success' => true, 'percentage' => $subtask->percentage]);
        } catch (\Exception $e) {
            Log::error('updatePercentage error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /**
     * Bulk approve/reject subtasks (used by AJAX bulk action)
     */
    public function bulkStatusStrategy(Request $request)
    {
        $ids = $request->input('ids', []);
        $status = $request->input('status', 'approved');

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'No subtasks selected'], 400);
        }

        try {
            $updated = [];
            foreach ($ids as $id) {
                $subtask = Subtask::find($id);
                if (!$subtask) continue;

                if ($status === 'approved') {
                    $subtask->status = 'approved';
                    $subtask->done = 1;
                    $subtask->finished_user_id = $subtask->user_id;
                    $subtask->save();

                    // add ticket transition if ticket exists
                    if ($subtask->ticket_id) {
                        TicketTransition::create([
                            'ticket_id' => $subtask->ticket_id,
                            'from_state' => 001,
                            'to_state' => $subtask->user_id,
                            'date' => date('Y-m-d H:i:s'),
                            'status' => 'strategy-approved',
                        ]);
                    }
                } elseif ($status === 'rejected') {
                    $subtask->status = 'rejected';
                    $subtask->percentage = 0;
                    $subtask->save();

                    if ($subtask->ticket_id) {
                        TicketTransition::create([
                            'ticket_id' => $subtask->ticket_id,
                            'from_state' => 001,
                            'to_state' => $subtask->user_id,
                            'date' => date('Y-m-d H:i:s'),
                            'status' => 'strategy-rejected',
                        ]);
                    }
                }

                $updated[] = $subtask->id;
            }

            calculatePercentages();

            return response()->json(['success' => true, 'updated' => $updated]);
        } catch (\Exception $e) {
            Log::error('bulkStatusStrategy error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /**
     * Show overdue subtasks (due_time passed and not approved)
     */
    public function overdue(Request $request)
    {
        // Only allow authenticated users (routes are in auth group)
        $query = Subtask::query();

        $query->where(function($q){
            $q->where('status', '!=', 'approved')
              ->orWhereNull('status');
        });

        $query->where('due_time', '<', now())
              ->orderBy('due_time', 'asc');

        $subtasks = $query->get();

        return view('subtask.overdue', compact('subtasks'));
    }
}
