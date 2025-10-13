
@php
//if isset get minDate and maxDate from the request
// if(isset($_GET['minDate']) && isset($_GET['maxDate'])){
//     $minDate = $_GET['minDate'];
//     $maxDate = $_GET['maxDate'];
//     $sent_tickets = \App\Models\Ticket::where('from_id',current_user_position()->id)->whereBetween('start_date', [$minDate, $maxDate])->orderBy('id', 'desc')->get();
// }else{
//     $sent_tickets = \App\Models\Ticket::where('from_id',current_user_position()->id)->orderBy('id', 'desc')->get();

// }
$minDate = isset($_GET['minDate']) && !empty($_GET['minDate']) ? $_GET['minDate'] : '2023-01-01';
$maxDate = isset($_GET['maxDate']) && !empty($_GET['maxDate']) ? $_GET['maxDate'] : '2050-12-31';

$query = \App\Models\Ticket::where('from_id', current_user_position()->id);

// if (isset($_GET['status']) && !empty($_GET['status'])) {
//     $query->where('status', $_GET['status']);
// }


if (isset($_GET['status']) && !empty($_GET['status'])) {
    $ticketIds = \App\Models\Subtask::where('status', $_GET['status'])->pluck('ticket_id');
    $query->whereIn('id', $ticketIds)->orWhere('status', $_GET['status']);
}


$sent_tickets = $query->whereBetween('start_date', [$minDate, $maxDate])->orderBy('id', 'desc')->get();
$aaa = 0;
            @endphp
            @foreach($sent_tickets as $sent_ticket)
            <tr>
             @php
               $subtaskk =  \App\Models\Subtask::where('ticket_id',$sent_ticket->id)->first();
            //    $due_time=date('Y-m-d h:i:s A', strtotime($sent_ticket->due_time));
            //     $done_time = $subtaskk->done_time??null;
            //     $done_time2 = $subtaskk->done_time??null;
            //     $done_time2  = date('Y-m-d h:i:s A', strtotime($done_time2));
            
            
            // Check if there is a done_time, otherwise set it to null
// Assuming $sent_ticket->due_time is provided in a format that strtotime() understands
// $due_time = new DateTime($subtaskk->due_time);
$due_time = isset($subtaskk->due_time) ? new DateTime($subtaskk->due_time) : null;
$done_time = isset($subtaskk->done_time) ? new DateTime($subtaskk->done_time) : null;
$due_time_string = isset($due_time) ? $due_time->format('Y-m-d h:i A') : 'N/A';

                $subtask_status = $subtaskk->status??null;

                if ($done_time !== null && $due_time > $done_time) {

                   $color = 'success';

               }elseif($due_time < now() && $sent_ticket->due_time < now() ){
                   $color = 'danger';
               }else{
                     $color = 'info';
               }
             @endphp
            
              
                <td>{{ $sent_ticket->id }} 
                @php
                echo $sent_ticket->subtask_id;
                @endphp</td>
                <td dir="rtl" style="width:200px;">{{ $sent_ticket->name }} </td>
                    <td>
                     
                    @if($sent_ticket->images->count() >0)
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $sent_ticket->id }}">
                            <i class="fas fa-file"></i>
                        </button>
                        @endif

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $sent_ticket->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">المرفقات</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    @if($sent_ticket && $sent_ticket->images)

@foreach ($sent_ticket->images as $image)
<a href="
@php
if ($_SERVER['HTTP_HOST'] == 'strategy.qimam-community.com') {
    $newFilePath = str_replace("public", "/public/storage", $image->filepath);
} else {
    $newFilePath = str_replace("public", "/storage", $image->filepath);
}
echo $newFilePath;
@endphp
" target="_blank" >{{ $image->filename }}</a><hr />
    
@endforeach
@endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td>
                {{-- @php print_r($sent_ticket->images) @endphp --}}
               
                </td>


                <td dir="rtl"><span class="badge badge-{{ $color }}" style="">{{ \Carbon\Carbon::parse($subtaskk->due_time ?? $sent_ticket->due_time)->format('d-m-Y') }} | {{ \Carbon\Carbon::parse($subtaskk->due_time ?? $sent_ticket->due_time)->format('h:i') }} {{ \Carbon\Carbon::parse($subtaskk->due_time ?? $sent_ticket->due_time)->format('A') == 'AM' ? 'ص' : 'م' }}</span></td>
                {{-- <td><span style="color:{{ $color }}">
                 
                    {{ $subtaskk->due_time ??$sent_ticket->due_time }} </span></td> --}}
              
              
                <td style="display: none !important;">
                    <ul>@foreach($sent_ticket->ticketTransitions as $ticket_transition) <li>{{ (user_position($ticket_transition->from_state)->name ?? '') . ' - ' . (user_position($ticket_transition->to_state)->name ?? '') }}
                </li> @endforeach</ul>
            </td>
               
                {{-- <td>{{ \App\Models\EmployeePosition::where('id',$pending_ticket->to_id)->first()->name }}</td> --}}
                <td>@php
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
</div></td>
                <td>
                    @php
                    $subtask_info  =\App\Models\Subtask::where('ticket_id',$sent_ticket->id)->first();
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
                <button type="button" class="btn  status-history" data-toggle="modal" data-target="#status-history" ticketid="{{ $sent_ticket->id }}">
             
               
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
                <td>
                    @if(isset($subtask_info->id))
                        <a href="{{ url(env('APP_URL_REAL').'/mysubtasks-evidence/'.$subtask_info->id ) }}" target="_blank">عرض</a>
                    @else
                        <span>لا يوجد دليل</span>
                    @endif
                </td>
                    <td><a href="{{ env('APP_URL_REAL') }}/ticketsshow/{{ $sent_ticket->id }}" target="_blank">عرض</a>
            
            </td>
                <td>
                   
                    @php
                            $imagess = isset($subtask_info->id) ? $subtask_info->getMedia('images') : [];
                           if(isset($subtask_info)){
                                $subtask_s= $subtask_info->status;
                            }else{
                               $subtask_s= '';

                           }
                    @endphp
                    
                  <div class="d-flex align-items-center">
    @if(isset($subtask_info->id) && $imagess->count() > 0)
        <a href="{{ url(env('APP_URL_REAL').'/mysubtasks-evidence/'.$subtask_info->id ) }}" class="btn btn-info mr-2" target="_blank">
            <i class="fas fa-file"></i>
        </a>
    @endif

    @php
    //select from subtasks where ticket_id = $sent_ticket->id
    $ssubtask = \App\Models\Subtask::where('ticket_id', $sent_ticket->id)->first();
    //if the subtasks exsists set sstatus variable to the $subtask->status else set it to null 
    $sstatus = isset($ssubtask) ? $ssubtask->status : null;

    @endphp
    @if(current_user_position()->id == $sent_ticket->from_id && $sstatus != 'approved')
        <!-- <a href="{{ url('/tickets/' . $sent_ticket->id . '/edit') }}" class="btn btn-primary mr-2">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ url('/ticketdelete/' . $sent_ticket->id) }}" method="POST" class="d-inline-block" style="    margin-bottom: 0px;
    margin-right: 8px;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ticketId" value="{{ $sent_ticket->id }}">
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form> -->
    @endif
</div>

                </td>

            

              </tr>
            @endforeach