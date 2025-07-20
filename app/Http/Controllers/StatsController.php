<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
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
