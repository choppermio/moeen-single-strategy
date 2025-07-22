<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hadafstrategy;
use App\Models\EmployeePosition;
use App\Models\EmployeePositionRelation;
use App\Models\Subtask;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function dashboard()
    {
        // Check if user is admin
        if (!is_admin()) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
        }

        // 1. متوسط الأهداف الاستراتيجية
        $strategicGoalsAverage = Hadafstrategy::avg('percentage') ?? 0;

        // 2. متوسط أداء كل إدارة
        $departmentPerformance = $this->getDepartmentPerformance();

        // 3. متوسط أداء كل موظف
        $employeePerformance = $this->getEmployeePerformance();

        // 4. عدد المهام المنجزة
        $completedTasks = Subtask::where('percentage', 100)->count();

        // 5. عدد المهام المتأخرة
        $overdueTasks = $this->getOverdueTasks();

        // 6. عدد المهام قيد العمل
        $inProgressTasks = Subtask::where('percentage', '<', 100)->count();

        // Additional summary statistics
        $totalTasks = Subtask::count();
        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        return view('stats.dashboard', compact(
            'strategicGoalsAverage',
            'departmentPerformance',
            'employeePerformance',
            'completedTasks',
            'overdueTasks',
            'inProgressTasks',
            'totalTasks',
            'completionRate'
        ));
    }

    private function getDepartmentPerformance()
    {
        // Get all departments that either have children or are top-level departments
        $allDepartmentIds = EmployeePosition::pluck('id')->toArray();
        $departmentsWithChildren = EmployeePositionRelation::distinct()->pluck('parent_id')->toArray();
        $topLevelDepartments = EmployeePosition::whereNotIn('id', 
            EmployeePositionRelation::pluck('child_id')->toArray()
        )->pluck('id')->toArray();
        
        $departmentIds = array_unique(array_merge($departmentsWithChildren, $topLevelDepartments));
        $departments = EmployeePosition::whereIn('id', $departmentIds)->get();

        $performance = [];        foreach ($departments as $department) {
            $childrenIds = $this->getAllChildrenIds($department->id);
            // Note: We don't include the department head in the count - only their subordinates
            // $childrenIds[] = $department->id; // This was causing the count to be off by 1

            // For performance calculation, we might want to include the department head's tasks
            $performanceIds = $childrenIds;
            $performanceIds[] = $department->id; // Include department head for performance metrics

            $avgPercentage = Subtask::whereIn('user_id', $performanceIds)
                ->avg('percentage') ?? 0;

            $performance[] = [
                'id' => $department->id,
                'name' => $department->name,
                'average_percentage' => round($avgPercentage, 2),
                'employees_count' => count($childrenIds)+1, // Count only subordinates
                'total_tasks' => Subtask::whereIn('user_id', $performanceIds)->count(),
                'completed_tasks' => Subtask::whereIn('user_id', $performanceIds)->where('percentage', 100)->count()
            ];
        }

        return collect($performance)->sortByDesc('average_percentage');
    }

    private function getEmployeePerformance()
    {
        // Get all employee positions that have associated subtasks
        $employeesWithTasks = Subtask::distinct()->pluck('user_id')->toArray();
        $employees = EmployeePosition::all();
        
        $performance = [];

        foreach ($employees as $employee) {
            $avgPercentage = Subtask::where('user_id', $employee->id)
                ->avg('percentage') ?? 0;

            $totalTasks = Subtask::where('user_id', $employee->id)->count();
            $completedTasks = Subtask::where('user_id', $employee->id)
                ->where('percentage', 100)->count();

            if ($totalTasks > 0) {
                $performance[] = [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'user_name' => $employee->user ? $employee->user->name : $employee->name,
                    'average_percentage' => round($avgPercentage, 2),
                    'total_tasks' => $totalTasks,
                    'completed_tasks' => $completedTasks,
                    'completion_rate' => round(($completedTasks / $totalTasks) * 100, 2)
                ];
            }
        }

        return collect($performance)->sortByDesc('average_percentage');
    }

    private function getOverdueTasks()
    {
        $now = Carbon::now();
        
        // Tasks that are overdue (due_time has passed and not completed)
        return Subtask::
            whereColumn('due_time', '<', 'done_time')
            ->count();
    }

    private function getAllChildrenIds($parentId)
    {
        $childrenIds = [];
        $directChildren = EmployeePositionRelation::where('parent_id', $parentId)
            ->pluck('child_id')
            ->toArray();

        foreach ($directChildren as $childId) {
            $childrenIds[] = $childId;
            $childrenIds = array_merge($childrenIds, $this->getAllChildrenIds($childId));
        }

        return $childrenIds;
    }

    public function sidepanelnotificationnumber()
    {
        $user_id = current_user_position()->id;
        $subtasksApprovalCount = \App\Models\Subtask::where('parent_user_id', $user_id)
                    ->where('percentage', '!=', 100)
                    ->whereIn('status', ['pending-approval'])
                    ->count();
        $subtasksNewCount =  \App\Models\Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->where('status','!=','pending-approval')->where('status','!=','approved')->count();

          $current_user_id = current_user_position()->id;
         $approved_tickets_count= \App\Models\Ticket::where('status','approved')->where('task_id',0)->where('to_id',$current_user_id)->orderBy('id', 'desc')->count();
         $needapproval_tickets_count= \App\Models\Ticket::where('status','pending')->where('to_id',$current_user_id)->orderBy('id', 'desc')->count();
        $ticketsCount = $approved_tickets_count + $needapproval_tickets_count;

        return response()->json([
            'subtasks_approval_count' => $subtasksApprovalCount,
            'subtasks_new_count' => $subtasksNewCount,
            'total_subtasks_count' => $subtasksApprovalCount + $subtasksNewCount,
            'approved_tickets_count' => $approved_tickets_count,
            'needapproval_tickets_count' => $needapproval_tickets_count,
            'tickets_count' => $ticketsCount,
        ]);
    }
}
