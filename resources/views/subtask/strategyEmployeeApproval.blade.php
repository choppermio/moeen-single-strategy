@extends('layouts.admin')
@php

@endphp

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
@php
// $admin =isset($_GET['approve']) 1:0;
$user_id  = auth()->user()->id;

    //     $user_under = \App\Models\User::where('parent_id',$user_id)->get();
//     //    $subtasks = \App\Models\Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->whereIn('status',[ 'pending-approval' ])->get();
//     $user_under = \App\Models\User::where('parent', $user_id)->pluck('id');
// $user_ids = $user_under->push($user_id); // Push the current user ID into the collection

// $subtasks = \App\Models\Subtask::whereIn('user_id', $user_ids)->where('status',[ 'strategy-pending-approval' ])->get();
// // dd($subtasks);

    $admin=1;

@endphp
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--fontawesome cdn-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<div class="container-fluid" style="overflow: auto;">
    <x-page-heading :title="'الموافقة على المهام'"  />

    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>المهمة</th>
                <th>مسؤول المهمة</th>
                <th>الإجراء الرئيسي</th>
                <th>مخرج الإجراء</th>
                 <th>المبادرة</th> 
                <th>نسبة الإكتمال</th>
                <th>الشواهد</th>
                <th>المخرج</th>
                <th>تصحيح الإجراء</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($subtasks as $subtask)
            <tr>
                @php
                $task = \App\Models\Task::where('id',$subtask->parent_id)->first();
                @endphp
                <td>{{ $subtask->name }}</td>
                <td>{{ \App\Models\EmployeePosition::where('id', $subtask->user_id)->first()->name }}</td>
                <td>{{ $task->name }} ({{\App\Models\EmployeePosition::where('id',$task->user_id)->first()->name}})</td>
                <td>
                {{ $task->output }}
                </td>
                @php
                $mubadara_info = \App\Models\Mubadara::where('id',$task->parent_id)->first();
                @endphp
                <td>{{$mubadara_info->name}} ({{\App\Models\EmployeePosition::where('id',$mubadara_info->user_id)->first()->name}})</td>
                <td>{{ $subtask->percentage }} %</td>
                <td> <a href="{{ url(env('APP_URL_REAL').'/mysubtasks-evidence/'.$subtask->id) }}" class="btn btn-info" target="_blank">الشواهد</a></td>
                <td>{{ $task->output }}</td>

        <td>
            <form action="/" method="POST">
                <input type="hidden" name="subtask_id" value="{{ $subtask->id }}">
                <select>
                    @php
                         $taskIds = \App\Models\TaskUserAssignment::where('employee_position_id', $subtask->user_id)
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
                    @endphp
                  
                </select>
                <button type="submit" class="btn btn-primary">إجراء</button>

            </form>

        </td>
                <td>
                   
                    @if($admin ==1)
                    <form method="POST" action="{{ route('subtask.statusstrategy') }}">
                        @csrf
                        <input type="hidden" name="taskid" value="{{ $subtask->id }}"/>
                        <input type="hidden" name="status" value="approved"/>

                        {{-- data-toggle="modal" data-target="#exampleModal" --}}
                    {{-- <button type="submit" class="btn btn-primary button_change_satatus btn-sm d-inline"  taskid="{{$subtask->id}}" taskname="{{$subtask->name}}">
                        <i class="fas fa-check"></i>
                    </button>
                    </form>
                    <form method="post" action="{{route('subtask.statusstrategy')}}" class="d-inline">
                        @csrf
                        <input type="hidden" name="taskid" value="{{ $subtask->id }}"/>
                        <input type="hidden" name="status" value="rejected"/>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                        <textarea name="notes" class="form-control" placeholder="سبب الرفض" required></textarea>


                    </form>
                    @else
                    <form method="post" action="{{ route('subtask.attachment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="subtask" value="{{ $subtask->id }}"/>
                        <input type="file" name="image" />
                        <input type="submit" />
                    </div>
                    </form>
@endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table> --}} 





<div class="container-fluid mt-4">
    <ul class="nav nav-tabs" id="subtaskTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">الحالية</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab" aria-controls="approved" aria-selected="false">المقبولة</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">المرفوضة</a>
        </li>
    </ul>
    <div class="tab-content" id="subtaskTabsContent">
        <!-- Pending Tab -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <div class="d-flex justify-content-between mb-2">
                <div></div>
                <div>
                    <button id="bulkApproveBtn" class="btn btn-success btn-sm">اعتماد المحدد</button>
                </div>
            </div>
            <table class="table table-bordered" id="datatable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all" /></th>
                        <th>#</th>
                        <th>المهمة</th>
                        <th>مسؤول المهمة</th>
                        <th>الوصف</th>
                        
                        <th>نسبة الإكتمال</th>
                        <th>الشواهد</th>
                        <th>المخرج</th>
                        <th>الحالة</th>
                        <th>التحديثات</th>
                         <th>تصحيح الإجراء</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subtasks as $subtask)
                        @php
                            $task = \App\Models\Task::where('id', $subtask->parent_id)->first();
                            
                                $mubadara_info = \App\Models\Mubadara::where('id', $task->parent_id)->first();
                            
                        @endphp
                        <tr class="aa{{ $subtask->id }}" data-subtask-id="{{ $subtask->id }}">
                            <td><input type="checkbox" class="select-subtask" value="{{ $subtask->id }}" /></td>
                            <td>{{ $subtask->ticket_id }}</td>
                            <td>{{ $subtask->name }}
                
                       <div>
                             <span class="badge badge-secondary">مبادرة : {{ $mubadara_info->name }} ({{ \App\Models\EmployeePosition::where('id', $mubadara_info->user_id)->first()->name }})</span>
                            <span class="badge badge-info">الإجراء الرئيسي : {{ $task->name }} ({{ \App\Models\EmployeePosition::where('id', $task->user_id)->first()->name }}) </span>
                            <span class="badge badge-primary">مخرج الإجراء : {{ $task->output }}</span>
                        
                        </div>
                        
                        </td>
                                                                        <td>{{ \App\Models\EmployeePosition::where('id', $subtask->user_id)->first()->name }}</td>

                            <td>
                                @php
                                    $note =  \App\Models\Ticket::where('id',$subtask->ticket_id)->first()->note;
                                    $uniqueId =  $subtask->ticket_id;
                                @endphp
                                <div style="width:200px;">
                                    <div id="shortNote_{{ $uniqueId }}" class="collapse show">
                                        {{ Str::limit($note, 30) }}
                                        @if(strlen($note) > 30)
                                            <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
                                        @endif
                                    </div>
                                    <div id="fullNote_{{ $uniqueId }}" class="collapse">
                                        {{ $note }}
                                        <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
                                    </div>
                                </div>
                                </td>
                            
                         
                          
                            <td class="subtask-percentage-cell" data-subtask-id="{{ $subtask->id }}">
                                <span class="percentage-display">{{ $subtask->percentage }} %</span>
                                <a href="#" class="ml-2 edit-percentage" title="تعديل النسبة"><i class="fas fa-edit"></i></a>
                                <div class="percentage-edit" style="display:none;">
                                    <input type="number" class="form-control form-control-sm percentage-input" min="0" max="100" value="{{ $subtask->percentage }}" style="width:80px;display:inline-block;" />
                                    <button class="btn btn-sm btn-primary save-percentage">حفظ</button>
                                    <button class="btn btn-sm btn-secondary cancel-percentage">إلغاء</button>
                                </div>
                            </td>
                            <td><a href="{{ url(env('APP_URL_REAL') . '/mysubtasks-evidence/' . $subtask->id) }}" class="btn btn-info" target="_blank">الشواهد</a></td>
                            <td>{{ $task->output }}</td>



                            {{-- <td>@php
                                $uniqueId = uniqid();
                            @endphp
                            <div style="width:200px;">
                                <div id="shortNote_{{ $uniqueId }}" class="collapse show">
                                    {{ Str::limit($sent_ticket->note, 30) }}
                                    @if(strlen($sent_ticket->note) > 30)
                                        <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
                                    @endif
                                </div>
                                <div id="fullNote_{{ $uniqueId }}" class="collapse">
                                    {{ $sent_ticket->note }}
                                    <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
                                </div>
                            </div></td> --}}
                                            <td>
                                                @php
                                                $subtask_info  =\App\Models\Subtask::where('ticket_id',$subtask->ticket_id)->first();
                                                // $ticket_transitions = \App\Models\TicketTransition::where('ticket_id', $subtask->ticket_id)->get();
                                                $ticket_transition = \App\Models\TicketTransition::where('ticket_id', $subtask->ticket_id)
    ->orderBy('id', 'desc')
    ->first();
                                                // dd($ticket_transition->status);
                                                $sent_ticket = \App\Models\Ticket::where('id', $subtask->ticket_id)->first();
                                                $sstatus = $subtask_info->status ??'null';
                                                if($sstatus == 'approved'){
                                                    $status = 'approved';
                                                }else{
                                                    $status = $sent_ticket->status;
                                                }
                                                
                                                if(isset($subtask_info)){
                                                    $status = $subtask_info->status;
                                                }else{
                                                    $status='pending';
                                                }
                                                $status = $sent_ticket->status;
                                                @endphp
                                            <button type="button" class="btn  status-history" data-toggle="modal" data-target="#status-history" ticketid="{{ $subtask->ticket_id }}">
                                         
                                           
                                          {{-- @switch($status)
                                @case('pending')
                                    <span class="badge badge-warning">بانتظار الموافقة</span>
                                    @break
                            
                                @case('pending-approval')
                                    <span class="badge badge-warning">بانتظار الموافقة</span>
                                    @break
                            
                                @case('strategy-pending-approval')
                                    <span class="badge badge-warning">بانتظار الموافقة</span>
                                    @break
                            
                                @case('rejected')
                                    <span class="badge badge-danger">تم الرفض</span>
                                    @break
                            
                                @case('approved')
                                    <span class="badge badge-success">تمت الموافقة</span>
                                    @break
                            
                                @case('transfered')
                                    <span class="badge badge-warning">تمت عملية الإسناد</span>
                                    @break
                            
                                @default
                                    <!-- Optional: Handle unknown statuses -->
                                    <span class="badge badge-secondary">حالة غير معروفة</span>
                            @endswitch --}}
                            
                            @switch($ticket_transition->status)
                            @case('sent')
                            <span class="badge bg-primary">تم إرسال الطلب</span>
                            @break
                            @case('accept')
                            <span class="badge bg-info">تم قبول التذكرة</span>
                            @break
                            
                            @case('approved')
                            <span class="badge bg-success">تم قبول الطلب</span>
                            @break
                            
                            
                            @case('rejected')
                            <span class="badge bg-danger">تم رفض الطلب</span>
                            @break
                            @case('attachment-added')
                            <span class="badge bg-info">تم إضافة مرفق</span>
                            @break
                            @case('strategy-pending-approval')
                            <span class="badge bg-warning text-dark">بانتظار موافقة قسم الإستراتيجية</span>
                            @break
                            @case('strategy-rejected')
                            <span class="badge bg-danger">تم الرفض من قسم الإستراتيجية</span>
                            @break
                            @case('strategy-approved')
                            <span class="badge bg-success">تم الموافقة من قسم الإستراتيجية</span>
                            @break
                            @case('transfered-to-team-member')
                            <span class="badge bg-info">تم تحويل الطلب لموظف</span>
                            @break
                            
                            
                            @break
                            @default
                            @php
                             if(isset($subtask_info)){
                                                    $status = $subtask_info->status;
                                                }else{
                                                    $status='pending';
                                                }
                            @endphp
                            @switch($status)
                            @case('pending')
                                <span class="badge badge-warning">بانتظار الموافقة</span>
                                @break
                            
                            @case('pending-approval')
                                <span class="badge badge-warning">بانتظار الموافقة</span>
                                @break
                            
                            @case('strategy-pending-approval')
                                <span class="badge badge-warning">بانتظار الموافقة</span>
                                @break
                            
                            @case('rejected')
                                <span class="badge badge-danger">تم الرفض</span>
                                @break
                            
                            @case('approved')
                                <span class="badge badge-success">تمت الموافقة</span>
                                @break
                            
                            @case('transfered')
                                <span class="badge badge-warning">تمت عملية الإسناد</span>
                                @break
                            
                            @default
                                <!-- Optional: Handle unknown statuses -->
                                <span class="badge badge-secondary">حالة غير معروفة</span>
                            @endswitch
                            
                            @endswitch
                              
                                    </button>
                                                
                                           
                                              
                                            </td>




                            <td><a href="{{ url(env('APP_URL_REAL') . '/ticketsshow/' . $subtask->ticket_id) }}" target="_blank">عرض</a></td>
    
      <td>
                                @if($admin == 1)
                                    <form method="POST" action="{{ route('subtask.statusstrategy') }}" class="approvedform">
                                        @csrf
                                        <input type="hidden" name="taskid" value="{{ $subtask->id }}"/>
                                        <input type="hidden" name="status" value="approved"/>
                                        <button type="submit" class="btn btn-primary button_change_satatus btn-sm d-inline" taskid="{{ $subtask->id }}" taskname="{{ $subtask->name }}">
                                            <i class="fas fa-check loading-icon"></i>
                                            <span class="spinner-border spinner-border-sm loading-spinner" role="status" aria-hidden="true" style="display: none;"></span>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal" onClick="setRejectTaskId({{ $subtask->id }}, '{{ $subtask->name }}')" data-taskid="{{ $subtask->id }}" data-taskname="{{ $subtask->name }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @else
                                    <form method="post" action="{{ route('subtask.attachment') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="subtask" value="{{ $subtask->id }}"/>
                                        <input type="file" name="image" />
                                        <input type="submit" />
                                    </form>
                                @endif
                            </td>
    
    
                            <td>
            <form action="{{ route('subtask.changeTask') }}" method="POST" class="ajax-change-task">
                @csrf
                <input type="hidden" name="subtask_id" value="{{ $subtask->id }}">
                @php
                    $taskIds = \App\Models\TaskUserAssignment::where('employee_position_id', $task->user_id)
                        ->where('type', 'task')
                        ->pluck('task_id');

                    $directlyAssignedTasks = \App\Models\Task::where('user_id', $task->user_id)->pluck('id');
                    $allTaskIds = $taskIds->merge($directlyAssignedTasks)->unique();
                    $tasks = \App\Models\Task::whereIn('id', $allTaskIds)->get();
                @endphp
                <select name="task_id" class="form-control form-control-sm d-inline" style="width:auto;display:inline-block;">
                    @foreach($tasks as $taskon)
                        <option value="{{ $taskon->id }}" @if($taskon->id == $subtask->parent_id) selected @endif>{{ $taskon->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">إجراء</button>
            </form>

        </td>
                          
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Rejected Tab -->
        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
            @if($subtasks_rejected->count() > 0)
            <table class="table table-bordered " id="datatable2">
                <thead>
                    <tr>
                        <th>المهمة</th>
                        <th>مسؤول المهمة</th>
                        <th>الوصف</th>
                        <th>الإجراء الرئيسي</th>
                        <th>المخرج</th>
                       
                        <!-- <th>المبادرة</th> -->
                        <th>نسبة الإكتمال</th>
                        <th>الشواهد</th>
                        
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subtasks_rejected as $subtask)
                    

@php
$task = \App\Models\Task::where('id', $subtask->parent_id)->first();

    $mubadara_info = \App\Models\Mubadara::where('id', $task->parent_id)->first();

@endphp
                        <tr>
                            <td>{{ $subtask->name }}
                              <div>  <span class="badge badge-secondary">مبادرة : {{ $mubadara_info->name }} ({{ \App\Models\EmployeePosition::where('id', $mubadara_info->user_id)->first()->name }})</span>
                                <span class="badge badge-info">الإجراء الرئيسي : {{ $task->name }} ({{ \App\Models\EmployeePosition::where('id', $task->user_id)->first()->name }}) </span>
                                <span class="badge badge-primary">مخرج الإجراء:({{$task->output}})</span>
                            </div>
                            
                            </td>
                                            <td>{{ \App\Models\EmployeePosition::where('id', $subtask->user_id)->first()->name }}</td>
                
                                <td>
                                    @php
                                        $note =  \App\Models\Ticket::where('id',$subtask->ticket_id)->first()->note;
                                        $uniqueId =  $subtask->ticket_id;
                                    @endphp
                                    <div style="width:200px;">
                                        <div id="shortNote_{{ $uniqueId }}" class="collapse show">
                                            {{ Str::limit($note, 30) }}
                                            @if(strlen($note) > 30)
                                                <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
                                            @endif
                                        </div>
                                        <div id="fullNote_{{ $uniqueId }}" class="collapse">
                                            {{ $note }}
                                            <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
                                        </div>
                                    </div>
                                    </td>
                           <td>{{$task->name}}</td>
                           <td>{{$task->output}}</td>
                            <td>{{ $subtask->percentage }} %</td>
                            <td><a href="{{ url(env('APP_URL_REAL') . '/mysubtasks-evidence/' . $subtask->id) }}" class="btn btn-info" target="_blank">الشواهد</a></td>
                            <td>
                             
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        <!-- Approved Tab -->
        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
            @if($subtasks_approved->count() > 0)
            <table class="table table-bordered" id="datatable3">
                <thead>
                    <tr>
                        <th>المهمة</th>
                        <th>مسؤول المهمة</th>
                        <th>الوصف</th>
                        
                        <th>نسبة الإكتمال</th>
                        <th>الشواهد</th>
                        <th>المخرج</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subtasks_approved as $subtask)
                        @php
                          $task = \App\Models\Task::where('id', $subtask->parent_id)->first();

                            $mubadara_info = \App\Models\Mubadara::where('id', $task->parent_id)->first();

                            @endphp
                        <tr>
                           
                            <td>{{ $subtask->name }}
                                <div>
                                <span class="badge badge-secondary">مبادرة : {{ $mubadara_info->name }} ({{ \App\Models\EmployeePosition::where('id', $mubadara_info->user_id)->first()->name }})</span>
                                <span class="badge badge-info">الإجراء الرئيسي : {{ $task->name }} ({{ \App\Models\EmployeePosition::where('id', $task->user_id)->first()->name }})</span>
                                <span class="badge badge-primary">مخرج الإجراء : {{ $task->output }}</span>
                               
                            </div>
                            </td>
                                            <td>{{ \App\Models\EmployeePosition::where('id', $subtask->user_id)->first()->name }}</td>
                
                                <td>
                                    @php
                                        $note =  \App\Models\Ticket::where('id',$subtask->ticket_id)->first()->note;
                                        $uniqueId =  $subtask->ticket_id;
                                    @endphp
                                    <div style="width:200px;">
                                        <div id="shortNote_{{ $uniqueId }}" class="collapse show">
                                            {{ Str::limit($note, 30) }}
                                            @if(strlen($note) > 30)
                                                <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
                                            @endif
                                        </div>
                                        <div id="fullNote_{{ $uniqueId }}" class="collapse">
                                            {{ $note }}
                                            <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
                                        </div>
                                    </div>
                                    </td>


                          
                            <td>{{ $subtask->percentage }} %</td>
                            <td><a href="{{ url(env('APP_URL_REAL') . '/mysubtasks-evidence/' . $subtask->id) }}" class="btn btn-info" target="_blank">الشواهد</a></td>
                            <td>{{ $task->output }}</td>
                            <td>
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
</div>





  <!-- Modal -->
  <div class="modal fade status-history-modal" id="status-history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
         </div>
      </div>
    </div>
  </div>




<!-- Modal for rejection -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('subtask.statusstrategy') }}" id="rejectForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">رفض المهمة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="taskid" id="rejectTaskId"/>
                    <input type="hidden" name="status" value="rejected"/>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">المهمة: <span id="rejectTaskName"></span></h6>
                    </div>
                    
                    <div class="form-group">
                        <label for="rejectNotes">سبب الرفض <span class="text-danger">*</span></label>
                        <textarea name="notes" id="rejectNotes" class="form-control" rows="4" placeholder="يرجى كتابة سبب الرفض..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> رفض المهمة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for changing satus -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('subtask.statusstrategy') }}">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">تعديل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
                    @csrf
                    <div class="mb-3">
                        <h2 class="form-label taskname"></label>
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">الحالة</label>
                        <select class="form-control" id="taskStatus" name="task_status" required>
                            <option value="0">غير مكتمل</option>
                            <option value="2">مكتمل بشكل جزئي</option>
                            <option value="1">مكتمل</option>
                        </select>
<input type="hidden" name="taskid"/>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلاق</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


<script>
$(document).ready(function() {
// Inline percentage edit handler
$(document).ready(function(){
    // Show edit inputs
    $(document).on('click', '.edit-percentage', function(e){
        e.preventDefault();
        var cell = $(this).closest('.subtask-percentage-cell');
        cell.find('.percentage-display, .edit-percentage').hide();
        cell.find('.percentage-edit').show();
    });

    // Cancel
    $(document).on('click', '.cancel-percentage', function(e){
        e.preventDefault();
        var cell = $(this).closest('.subtask-percentage-cell');
        cell.find('.percentage-edit').hide();
        cell.find('.percentage-display, .edit-percentage').show();
    });

    // Save
    $(document).on('click', '.save-percentage', function(e){
        e.preventDefault();
        var cell = $(this).closest('.subtask-percentage-cell');
        var subtaskId = cell.data('subtask-id');
        var input = cell.find('.percentage-input');
        var newVal = parseInt(input.val());
        if (isNaN(newVal) || newVal < 0 || newVal > 100) {
            alert('القيمة يجب أن تكون بين 0 و 100');
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).text('جارٍ الحفظ...');

        var token = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').first().val();

        $.ajax({
            url: '{{ route('subtask.updatePercentage') }}',
            method: 'POST',
            data: {
                _token: token,
                subtask_id: subtaskId,
                percentage: newVal
            },
            success: function(resp){
                if(resp.success){
                    cell.find('.percentage-display').text(resp.percentage + ' %');
                    cell.find('.percentage-edit').hide();
                    cell.find('.percentage-display, .edit-percentage').show();
                } else {
                    alert(resp.message || 'حدث خطأ');
                }
            },
            error: function(xhr){
                alert('حدث خطأ في الخادم');
            },
            complete: function(){
                $btn.prop('disabled', false).text('حفظ');
            }
        });
    });
});
    $('.approvedform').on('submit', function(e) {
        e.preventDefault();

        var taskid = $(this).find('input[name="taskid"]').val();
        var formData = $(this).serialize();
        $(this).find('i').hide();
        $(this).find('.loading-spinner').show();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                // Hide the tr with class aa+taskid
                $('.aa' + taskid).fadeOut();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });

    // AJAX handler for changing parent task (transfer)
    $(document).on('submit', 'form.ajax-change-task', function(e){
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originalHtml = btn.html();
        btn.prop('disabled', true).html('جاري الحفظ...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(resp){
                if(resp && resp.success){
                    // update the task badge (الإجراء الرئيسي) in the same row
                    var row = form.closest('tr');
                    var badgeHtml = '';
                    if(resp.task_name){
                        var owner = resp.task_owner_name ? ' (' + resp.task_owner_name + ')' : '';
                        badgeHtml = '<span class="badge badge-info">الإجراء الرئيسي : ' + resp.task_name + owner + '</span>';
                        // replace existing badge(s)
                        row.find('span.badge-info').remove();
                        row.find('td').eq(1).append(badgeHtml);
                    }
                    alert('تم تحديث الاجراء');
                } else {
                    alert(resp.message || 'حدث خطأ أثناء تحديث المهمة');
                }
            },
            error: function(xhr){
                alert('خطأ في الخادم');
            },
            complete: function(){
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // Handle rejection form submission
    $('#rejectForm').on('submit', function(e) {
    
        e.preventDefault();
        
        var taskid = $('#rejectTaskId').val();
        var formData = $(this).serialize();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                // Hide the tr with class aa+taskid
                $('.aa' + taskid).fadeOut();
                // Hide the modal
                $('#rejectModal').modal('hide');
                // Clear the form
                $('#rejectNotes').val('');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });
});

// Function to set task ID and name for rejection
function setRejectTaskId(taskId, taskName) {
    $('#rejectTaskId').val(taskId);
    $('#rejectTaskName').text(taskName);
}
</script>
<script>
    // Bulk select / approve handlers
    $(document).ready(function(){
        $('#select-all').on('change', function(){
            var checked = $(this).is(':checked');
            $('.select-subtask').prop('checked', checked);
        });

        $('#bulkApproveBtn').on('click', function(e){
            e.preventDefault();
            var ids = $('.select-subtask:checked').map(function(){ return $(this).val(); }).get();
            if(ids.length === 0){
                alert('يرجى اختيار مهام للموافقة عليها');
                return;
            }

            if(!confirm('هل أنت متأكد من اعتماد المهام المحددة؟')) return;

            var token = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').first().val();

            $.ajax({
                url: '{{ route('subtask.bulkStatusStrategy') }}',
                method: 'POST',
                data: {
                    _token: token,
                    ids: ids,
                    status: 'approved'
                },
                success: function(resp){
                    if(resp.success){
                        resp.updated.forEach(function(id){
                            $('.aa' + id).fadeOut();
                        });
                        alert('تم اعتماد ' + resp.updated.length + ' مهمة');
                    } else {
                        alert(resp.message || 'حدث خطأ');
                    }
                },
                error: function(xhr){
                    alert('خطأ في الخادم');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {




    
        $(document).on('click', '.status-history', function() {
       
            // Get the ticket ID from the data attribute
            var ticketId = $(this).attr('ticketid');
    
            var baseUrl = '{{ url("/ticket/history") }}';

// Construct the full URL
var url = baseUrl + '/' + ticketId;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    // Update the modal body with the response HTML
                    $('.status-history-modal .modal-body').html(response);
    
                    // Optionally, you can show the modal if it's hidden
                    // $('.status-history-modal').modal('show'); // Uncomment if using a modal plugin like Bootstrap
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });
    });
    </script>

<script>
   $('.button_add_task').click(function(){
       var taskid = $(this).attr('taskid');
       var taskname = $(this).attr('taskname');
    //    $('modal_change_satatus').modal('show');
       $('input[name="taskid"]').val(taskid);
       $('.taskname').html(taskname);
   });


   $('.button_change_satatus').click(function(){
       var taskid = $(this).attr('taskid');
       var taskname = $(this).attr('taskname');
    //    $('modal_change_satatus').modal('show');
       $('input[name="taskid"]').val(taskid);
       $('.taskname').html(taskname);
   });


$('span').click(function(){
    // $(this).parent().children('ul').css('background','red');
    //toggle all children
    $(this).parent().children('ul').toggle();
   // $(this).children('li').toggle();
});
</script>
<!-- Include DataTables CSS -->

<!-- Include DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<script>
$(document).ready(function() {
    $('#datatable').DataTable();
    $('#datatable3').DataTable();
    $('#datatable2').DataTable();
});
</script>

@endsection