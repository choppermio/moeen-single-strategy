@extends('layouts.admin')
{{-- @dd($needapproval_tickets) --}}

@php
$baseUrl = parse_url(env('APP_URL'), PHP_URL_HOST);
@endphp
<style>

    .badge{color:white!important;}
    .modal-lg {
    max-width: 80% !important;
}
</style>
 <!-- DataTables CSS -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
 <!-- DataTables Buttons CSS -->
 <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

@php
           
           $current_user  = auth()->user()->id;
           $employee_position = \App\Models\EmployeePosition::where('user_id',$current_user)->first();
        // dd($employee_position);
        $children_employee_positions = \App\Models\EmployeePositionRelation::where('parent_id',$employee_position->id)->get()->pluck('childPosition');
        
        $childPositionIds = \App\Models\EmployeePositionRelation::where('parent_id', $employee_position->id)
                                                        ->get()
                                                        ->pluck('childPosition')
                                                        ->toArray();
                                                        $childPositionIds = is_array($childPositionIds) ? $childPositionIds : [$childPositionIds];
                                                        $childPositionIds = array_column($childPositionIds, 'id');
                                                        // dd($childPositionIds);
                                                        //    dd('a');
                                                            $tasks = \App\Models\Task::whereIn('user_id', $childPositionIds)->get() ?? [];
// dd($tasks);
// dd($pending_tickets);
                                                            
                                                        
        //dd($children_employee_positions);
   
                
                @endphp
@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- Ensure Bootstrap CSS is loaded -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Custom styles -->
<style>
    .badge{color:white!important;}
    .modal-lg {
        max-width: 80% !important;
    }
</style>

@php
//  dd($pending_tickets);

@endphp
<div class="container-fluid mt-5">
    <x-page-heading :title="'التذاكر'"  />
    @php
    $current_user_id = current_user_position()->id;
         $approved_tickets_count = \App\Models\Ticket::where('status', 'approved')->where('to_id', $current_user_id)->where(function($query) {
             $query->where('task_id', '=', 0)->orWhereNull('task_id');
         })->orderBy('id', 'desc')->count();
         $needapproval_tickets_count= \App\Models\Ticket::where('status','pending')->where('to_id',$current_user_id)->orderBy('id', 'desc')->count();
    @endphp
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <style>
            #myTab .nav-item {
                margin: 0 10px;
            }
            
            #myTab .nav-link {
                color: #333;
                border-radius: 5px;
                transition: all 0.3s ease;
                font-weight: bold;background: #e1e1e1 ;
            }
            
            #myTab .nav-link:hover {
                background-color: #f8f9fa !important;
                color: #007bff;
            }
            
            #myTab .nav-link.active {
                background-color: #2797b4 !important;
                color: #fff !important;
            }
            .tab-content{padding-top:30px;}
            </style>
            
        <li class="nav-item">
            <a class="nav-link active" id="approved-tab" data-toggle="tab" href="#approved" role="tab"
                aria-controls="approved" aria-selected="true">الموافق عليها
                <span class="badge bg-red badgered" >{{ $approved_tickets_count }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab"
                aria-controls="rejected" aria-selected="false">المرفوض</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                aria-controls="pending" aria-selected="false">المعلق</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="needapproval-tab" data-toggle="tab" href="#needapproval" role="tab"
                aria-controls="needapproval" aria-selected="false">تحتاج إلى موافقة
                <span class="badge bg-red badgered" >{{ $needapproval_tickets_count }} 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sent-tab" data-toggle="tab" href="#sent" role="tab"
                aria-controls="sent" aria-selected="false">المرسلة من قبلي</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- موافقةd Tab Content -->
        <div class="tab-pane fade show active" id="approved" role="tabpanel" aria-labelledby="approved-tab"  style="overflow: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>المرفقات</th>
                        <th>المعاملات السابقة</th>
                        {{-- <th>من</th> --}}
                        <th>ملاحظات</th>
                        <th>تاريخ انتهاء المهمة</th>
                        <th>تعيين لموظف</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($approved_tickets as $approved_ticket)
                   <tr>
                       <td>{{ $approved_ticket->id }}
                        {{-- @dd($approved_ticket->ticketTransitions) --}}
                    
                    </td>
                    
                    <td>{{ $approved_ticket->name }}</td>
                    <td>
                        @if($approved_ticket && $approved_ticket->images)

                        @foreach ($approved_ticket->images as $image)
                        <a href="
                        @php
                        if ($_SERVER['HTTP_HOST'] == 'strategy.moeen-sa.com') {
                                                   $baseUrl = parse_url(env('APP_URL'), PHP_URL_HOST);

                        if ($_SERVER['HTTP_HOST'] == $baseUrl) {
                            $newFilePath = str_replace("public", "/public/storage", $image->filepath);
                        } else {
                            $newFilePath = str_replace("public", "/storage", $image->filepath);
                        }
                        echo $newFilePath;
                        @endphp
                        " target="_blank" >{{ $image->filename }}</a><hr />
                            
                        @endforeach
                        @endif
                    </td>
                    <td>
                        <ul>@foreach($approved_ticket->ticketTransitions as $ticket_transition) <li>{{ user_position($ticket_transition->from_state)->name ?? ''.' - '.user_position($ticket_transition->to_state)->name??'' }}</li> @endforeach</ul>
                    </td>
                       {{-- <td>{{ \App\Models\EmployeePosition::where('id',$approved_ticket->to_id)->first()->name }}</td> --}}
                       <td><div style=" width:200px;">{{ $approved_ticket->note }}</div></td>
                       <td>{{ $approved_ticket->due_time }}</td>
                    
                       <td>
                        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary setuser" idd="{{ $approved_ticket->id }}" namee="{{ $approved_ticket->name }}" data-toggle="modal" data-target="#exampleModalCenter">
    تعيين لموظف
  </button>
                       </td>
                     </tr>
                   @endforeach
                </tbody>
            </table>
        </div>

        <!-- رفضed Tab Content -->
        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab"  style="overflow: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>المعاملات السابقة</th>
                        <th>ملاحظات</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejected_tickets as $rejected_ticket)
                    <tr>
                        <td>{{ $rejected_ticket->id }}</td>
                        <td>{{ $rejected_ticket->name }}</td>
                        <td>
                            {{-- <ul>@foreach($rejected_ticket->ticketTransitions as $ticket_transition) <li>{{ user_position($ticket_transition->from_state)->name??''.' - '.user_position($ticket_transition->to_state)->name??'' }}</li> @endforeach</ul> --}}
                            <ul>
                                @foreach($rejected_ticket->ticketTransitions as $ticket_transition)
                                    <li>
                                        {{ 
                                            (user_position($ticket_transition->from_state) ? user_position($ticket_transition->from_state)->name : 'N/A')
                                            . ' - ' .
                                            (user_position($ticket_transition->to_state) ? user_position($ticket_transition->to_state)->name : 'N/A')
                                        }}
                                    </li>
                                @endforeach
                            </ul>

                        </td>
                        {{-- <td>{{ \App\Models\EmployeePosition::where('id',$rejected_ticket->to_id)->first()->name }}</td> --}}
                        <td><div style=" width:200px;">{{ $rejected_ticket->note }}</div></td>
                      </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pending Tab Content -->
        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab"  style="overflow: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>المعاملات السابقة</th>
                        <th>ملاحظات</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending_tickets as $pending_ticket)
                    <tr>
                        @php
                        @endphp
                        <td>{{ $pending_ticket->id }}</td>
                        <td>{{ $pending_ticket->name }}</td>
                        <td><ul>@foreach($pending_ticket->ticketTransitions as $ticket_transition) <li>{{ (user_position($ticket_transition->from_state) ? user_position($ticket_transition->from_state)->name : 'N/A') . ' - ' . (user_position($ticket_transition->to_state) ? user_position($ticket_transition->to_state)->name : 'N/A') }}
                        </li> @endforeach</ul></td>

                        {{-- <td>{{ \App\Models\EmployeePosition::where('id',$pending_ticket->to_id)->first()->name }}</td> --}}
                        <td><div style=" width:200px;">{{ $pending_ticket->note }}</div></td>
                        
                        <td>
                            @if($pending_ticket->from_id == current_user_position()->id )
                            <form action="{{ route('tickets.destroy', $pending_ticket) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        @endif
                        </td>
                      </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

  <!-- sent Tab Content -->
  <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab" style="overflow: auto;">
    
    <div class="row mb-3" >

        <div class="col">
            <input type="date" id="min-date" class="form-control" placeholder="التاريخ من">
        </div>
        <div class="col">
            <input type="date" id="max-date" class="form-control" placeholder="التاريخ إلى">
        </div>
        <div class="col">
            <select class="form-control status-fiter" name="status">
                <option value="sent">تم إرسال الطلب</option>
                <option value="accept">تم قبول التذكرة</option>
                <option value="approved">تم قبول الطلب</option>
                <option value="rejected">تم رفض الطلب</option>
                <option value="attachment-added">تم إضافة مرفق</option>
                <option value="strategy-pending-approval">بانتظار موافقة قسم الإستراتيجية</option>
                <option value="strategy-rejected">تم الرفض من قسم الإستراتيجية</option>
                <option value="strategy-approved">تم الموافقة من قسم الإستراتيجية</option>
                <option value="transfered-to-team-member">تم تحويل الطلب لموظف</option>
                <option value="pending">بانتظار الموافقة</option>
                <option value="transfered">تمت عملية الإسناد</option>
                <option value="unknown">حالة غير معروفة</option>
            </select>
        </div>

        <div class="col">
            <button class="btn btn-primary" id="filterdate">فلترة</button>
        </div>
    </div>
    <table class="table table-hover bg-white table-striped  m-0" id="sent_table" style="width:100% !important;">
        <thead>
            <tr>
                <th>#</th>
                <th>الإسم</th>
                <th>المرفقات</th>
                <th>تاريخ الإنتهاء</th>
                <th style="display: none !important;">المعاملات السابقة</th>
                <th>ملاحظات</th>
                <th>الحالة</th>
                <th>الشواهد</th>
                <th>التحديثات</th>
                <th>إجراء</th>
                
            </tr>
        </thead>
        <tbody class="sent_data">
            
        </tbody>
    </table>
</div>

          <!-- Pending Tab Content -->
          <div class="tab-pane fade" id="needapproval" role="tabpanel" aria-labelledby="needapproval-tab"  style="overflow: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>المرفقات</th>
                        <th>المعاملات السابقة</th>
                        <th>الإجراء المحدد للمهمة</th>
                        <th>ملاحظات</th>
                        <th>تاريخ إنتهاء المهمة</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
               
                    @foreach($needapproval_tickets as $needapproval_ticket)
                    <tr>
                        <td>{{ $needapproval_ticket->id }}</td>
                        <td>{{ $needapproval_ticket->name }}</td>
                        <td>
                            @if($needapproval_ticket && $needapproval_ticket->images)
    
                            @foreach ($needapproval_ticket->images as $image)
                            <a href="
                            @php
                            if ($_SERVER['HTTP_HOST'] == $baseUrl) {
                                $newFilePath = str_replace("public", "/public/storage", $image->filepath);
                            } else {
                                $newFilePath = str_replace("public", "/storage", $image->filepath);
                            }
                            echo $newFilePath;
                            @endphp
                            " target="_blank" >{{ $image->filename }}</a><hr />
                                
                            @endforeach
                            @endif
                        </td>
                        <td>
                            {{ user_position($needapproval_ticket->user_id)->name }}
                            {{-- {{ user_position($needapproval_ticket->id)->name }} --}}
                            <ul>@foreach($needapproval_ticket->ticketTransitions as $ticket_transition) <li>{{ optional(user_position($ticket_transition->from_state))->name??'' . ' - ' . optional(user_position($ticket_transition->to_state))->name??'' }}
                            </li> @endforeach</ul>
                        </td>

                        {{-- <td>{{ \App\Models\EmployeePosition::where('id',$needapproval_ticket->to_id)->first()->name }}</td> --}}
                        <td>
                            @if($needapproval_ticket->task_id !=0)
                            {{ \App\Models\Task::where('id',$needapproval_ticket->task_id)->first()->name }}
                            @else
                            غير محدد
                            @endif

                        </td>
                        <td><div style=" width:200px;">{{ $needapproval_ticket->note }}</div></td>
                        <td>{{ $needapproval_ticket->due_time }}</td>

                        <td>
                        <form action="{{ route('ticket.changestatus', $needapproval_ticket->id) }}" method="POST" style="display: inline">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $needapproval_ticket->task_id }}">
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success"  onclick="return confirmSubmission()">موافقة</button>
                        </form>
                        <button type="button" class="btn btn-danger" onclick="showRejectModal({{ $needapproval_ticket->id }}, '{{ $needapproval_ticket->name }}', {{ $needapproval_ticket->task_id }})">رفض</button>
    
                        </td>
                      </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">رفض التذكرة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="rejected">
                    <input type="hidden" name="task_id" id="reject_task_id" value="">
                    <div class="form-group">
                        <label for="ticketName">اسم التذكرة:</label>
                        <input type="text" class="form-control" id="ticketName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="rejection_reason">سبب الرفض: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" placeholder="يرجى كتابة سبب رفض هذه التذكرة..." required style="border: 2px solid #dc3545; border-radius: 5px; min-height: 100px;"></textarea>
                        <small class="text-muted">سيتم إرسال سبب الرفض للمرسل وحفظه في سجل التذكرة</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">تعيين لموظف</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('ticket.settouser') }}">
        @csrf
        <input type="hidden" name="name" value="">
        <input type="hidden" name="ticket_mission" value="1">
        <input type="hidden" name="ticket_id" value="">
        <div class="form-group">
            <label for="exampleFormControlSelect1">اختر الموظف</label>
            <select class="form-control user-pick" id="exampleFormControlSelect1" name="user_id">
                @php
                 $current_user  = auth()->user()->id;
        $employee_position = \App\Models\EmployeePosition::where('user_id',$current_user)->first();
        $children_employee_positions = \App\Models\EmployeePositionRelation::where('parent_id',$employee_position->id)->get();

        // dd($children_employee_positions);
        
                
                @endphp
                <option value="{{ $employee_position->id }}">تعيين لنفسي</option>
              @foreach($children_employee_positions as $children_employee_position)
              @php
              $employee_position = \App\Models\EmployeePosition::where('id',$children_employee_position->child_id)->first();
              echo $employee_position;
              @endphp
              <option value="{{ $employee_position->id }}">{{ $employee_position->name }}</option>
              @endforeach
            </select>
            <div class="mubadaras">

                
                                <label for="exampleFormControlSelect1">اتركه فارغا اذا كنت تريد إرساله لشخص بدون اسناد لمهمة</label>

                        
                <select class="form-control taskpicker" id="exampleFormControlSelect1" name="task_id">
                  
                    {{-- <option value="{{ $employee_position->id }}">اختر اي قيمة من القيم</option> --}}
                    <option value="0">اختر اي قيمة من القيم</option>
                    @php
                        $current_employee_position_id  = current_user_position()->id;
                        $tasks = \App\Models\TaskUserAssignment::where('employee_position_id',$current_employee_position_id)->get();
                       
                    @endphp
                  @foreach($tasks as $task)
                    <option value="{{ $task->task->id }}">{{ $task->task->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" class="btn btn-primary" value="إسناد">
          </div>
        </form>
        </div>
        <div class="modal-footer">
                 </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
<div class="modal fade status-history-modal" id="status-history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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


  <!-- Scripts are loaded in admin layout - no need to reload jQuery -->
  <!-- DataTables JS - Load after jQuery from admin layout -->
   <!-- //jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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
$(document).ready(function(){

        // $('[data-toggle="tooltip"]').tooltip();
    $('.user-pick').on('change', function() {
        var userId = $(this).val();
        
        $.ajax({
            url: '{{env('APP_URL')==$baseUrl ? $baseUrl.'/public' :env('APP_URL') }}api/tasks/dropdown/' + userId,
ion>')
//             });
//         });
//     }
// });

function strip(html){
   let doc= new DOMParser().parseFromString(html, 'text/html');
   return doc.body.textContent || "";
}




function applydatatable(){
    var table = $('#sent_table').DataTable({
        order: [],

    });    
    //            url: '{{ config('app.url') == $baseUrl ? $baseUrl.'/public' : config('app.url') }}api/tasks/dropdown/' + userId,
            type:{ 'GET',

            
        
        var title = $(this).text();
        var title = title.replace(/<[^>]*>?/gm, '');
        console.log(title);
        // $(this).append('<br><select><option value="">Select '+title+'</option></select>');
    }
    });
    
    // Populate the select options and add event listener for filtering
    countt = 0;

    table.columns().every(function() {
        var column = this;
        var select = $('select', column.header());
        countt++;

        if(countt == 7){

            var uniqueValues = new Set();

column.data().unique().sort().each(function(d, j) {
    // dd = d;
    // var text = d.replace(/<[^>]*>?/gm, '');
    // if (!uniqueValues.has(text)) {
    //     uniqueValues.add(text);
    //     select.html('<option value="'+dd+'">'+dd+'</option>');
    // }
});


    }else{
        // column.data().unique().sort().each(function(d, j) {
        //     select.html('<option value="'+d+'">'+d+'</option>')
        // });
    }
        select.on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? '^'+val+'$' : '', true, false).draw();
        });
    });
}

//jquery ajax to fetch data to blade file tickets.ticketshow and put the data in the .sent_data tbody
$.ajax({
    url: '{{ route('tickets.ticketshow') }}',
    type: 'GET',
    success: function(response) {
        $('.sent_data').html(response);
        applydatatable();


    },
    error: function() {
        alert('Oops, something went wrong.');
    }
});



$('#filterdate').on('click', function() {
    var minDate = $('#min-date').val();
    var maxDate = $('#max-date').val();

$.ajax({
    //add to url the minDate and maxDate
    url: '{{ route('tickets.ticketshow') }}?minDate=' + minDate + '&maxDate=' + maxDate + '&status=' + $('.status-fiter').val(),
    // url: '{{ route('tickets.ticketshow') }}',
    type: 'GET',
    success: function(response) {
        //reset datatable
        $('#sent_table').DataTable().destroy();

        $('.sent_data').html(response);
        applydatatable();


    },
    error: function() {
        alert('Oops, something went wrong.');
    }
});
});





        $('.setuser').click(function(){
            var id = $(this).attr('idd');
            $('input[name="ticket_id"]').val(id);
            var name = $(this).attr('namee');
            $('input[name="name"]').val(name);
           // $('#exampleModalCenter').modal('show');
        });
    });
    </script>
<script>
    function confirmSubmission() {
        return confirm('هل أنت متأكد من القبول?');
    }
</script>
    
<script>
function confirmSubmission2() {
    return confirm('هل أنت متأكد من الرفض?');
}

function showRejectModal(ticketId, ticketName, taskId) {
    $('#ticketName').val(ticketName);
    $('#reject_task_id').val(taskId || '');
    $('#rejectForm').attr('action', '{{env("APP_URL")}}change-status/' + ticketId);
    $('#rejection_reason').val('');
    $('#rejectModal').modal('show');
}

// Add form validation for reject modal
$(document).ready(function() {
    $('#rejectForm').on('submit', function(e) {
        var rejectionReason = $('#rejection_reason').val().trim();
        if (rejectionReason === '') {
            e.preventDefault();
            alert('يرجى كتابة سبب الرفض قبل المتابعة');
            $('#rejection_reason').focus();
            return false;
        }
        
        if (rejectionReason.length < 10) {
            e.preventDefault();
            alert('سبب الرفض يجب أن يكون مفصلاً أكثر (10 أحرف على الأقل)');
            $('#rejection_reason').focus();
            return false;
        }
        
        return confirm('هل أنت متأكد من رفض هذه التذكرة؟ سيتم إرسال سبب الرفض للمرسل');
    });
});
</script>

@endsection
