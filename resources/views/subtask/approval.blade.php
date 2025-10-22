@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
@php
// $admin =isset($_GET['approve']) 1:0;
$user_id  = auth()->user()->id;

    //     $user_under = \App\Models\User::where('parent_id',$user_id)->get();
    //    $subtasks = \App\Models\Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->whereIn('status',[ 'pending-approval' ])->get();
//     $user_under = \App\Models\User::where('parent', $user_id)->pluck('id');
// $user_ids = $user_under->push($user_id); // Push the current user ID into the collection

// $subtasks = \App\Models\Subtask::whereIn('user_id', $user_ids)->where('status',[ 'pending-approval' ])->get();

    $admin=1;

@endphp
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--fontawesome cdn-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<div class="container-fluid">
    <x-page-heading :title="'الموافقة على المهام'"  />

    <table class="table table-bordered" id="approvalTable">
        <thead>
            <tr>
                <th>#</th>
                <th>المهمة</th>
                <th>المرفقات</th>
                <th>الملاحظات</th>
                <th>مرسلة من</th>
                <th>نسبة الإكتمال</th>
                <th>الشواهد</th>
                <th>التحديثات</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @php
           $user_id= \App\Models\EmployeePosition::where('user_id', auth()->user()->id)->first()->id;
$subtasks = \App\Models\Subtask::where('parent_user_id', $user_id)
                    ->where('percentage', '!=', 100)
                    ->whereIn('status', ['pending-approval'])
                    ->get(); 
                    @endphp
                    @if($subtasks->count() == 0)
                    <tr>
                        <td colspan="9" class="text-center">لا توجد مهام للموافقة عليها.</td>
                    </tr>
                    @endif
                             

                  
                    
                    

                     @if($subtasks->count() > 0)
            @foreach ($subtasks as $subtask)
            <tr data-subtask-id="{{ $subtask->id }}" id="subtask-row-{{ $subtask->id }}">
                @php
                $task = \App\Models\Task::where('id', $subtask->parent_id)->first();
                
                    $mubadara_info = \App\Models\Mubadara::where('id', $task->parent_id)->first();
                
            @endphp


                <td>{{ $subtask->ticket_id }}</td>
                <td>{{ $subtask->name }}
                    <div>     <span class="badge badge-secondary">مبادرة : {{ $mubadara_info->name }} ({{ \App\Models\EmployeePosition::where('id', $mubadara_info->user_id)->first()->name }})</span><br />
                         <span class="badge badge-info">الإجراء الرئيسي : {{ $task->name }} ({{ \App\Models\EmployeePosition::where('id', $task->user_id)->first()->name }}) </span>
                         <span class="badge badge-primary">مخرج الإجراء : {{ $task->output }}</span>
                     </div>
                     
                     </td>
                     
                 <td>
                        @php
                            // Get the ticket related to this subtask
                            $ticket = \App\Models\Ticket::where('id', $subtask->ticket_id)->first();
                            $baseUrl = env('APP_URL_REAL');
                        @endphp

                        @if($ticket && $ticket->images)
                            @foreach ($ticket->images as $image)
                                @php
                                    // Remove "public/" from the filepath since storage link maps /storage to /storage/app/public
                                    $cleanPath = str_replace('public/', '', $image->filepath);
                                    $newFilePath = $baseUrl . "/storage/" . $cleanPath;
                                @endphp
                                <!-- Attachment icon with tooltip and modal trigger -->
                                <a href="#" 
                                    class="attachment-icon" 
                                    data-toggle="modal" 
                                    data-target="#attachmentModal{{ $subtask->id }}" 
                                    title="عرض المرفقات">
                                     <i class="fas fa-paperclip"></i>
                                </a>

                                <!-- Modal for showing attachment names and links -->
                                <div class="modal fade" id="attachmentModal{{ $subtask->id }}" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel{{ $subtask->id }}" aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                                <div class="modal-header">
                                                     <h5 class="modal-title" id="attachmentModalLabel{{ $subtask->id }}">المرفقات</h5>
                                                     <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                                          <span aria-hidden="true">&times;</span>
                                                     </button>
                                                </div>
                                                <div class="modal-body">
                                                     <ul>
                                                          @foreach ($ticket->images as $img)
                                                                @php
                                                                     $cleanPath = str_replace('public/', '', $img->filepath);
                                                                     $fileUrl = $baseUrl . "/storage/" . $cleanPath;
                                                                @endphp
                                                                <li>
                                                                     <a href="{{ $fileUrl }}" target="_blank">{{ $img->filename }}</a>
                                                                </li>
                                                          @endforeach
                                                     </ul>
                                                </div>
                                          </div>
                                     </div>
                                </div>
                            @endforeach
                        @endif
                    </td>

                     
                         <td>@php
    $uniqueId = uniqid();
@endphp
<div style="width:200px;">
    <div id="shortNote_{{ $uniqueId }}" class="collapse show">
        {{ Str::limit($ticket && $ticket->note ? $ticket->note : '', 30) }}
        @if($ticket && strlen($ticket->note) > 30)
            <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
        @endif
    </div>
    <div id="fullNote_{{ $uniqueId }}" class="collapse">
        {{ $ticket && $ticket->note ? $ticket->note : '' }}
        <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
    </div>
</div></td>
                     <td>
                     
                        @php
                        $ticket = \App\Models\Ticket::where('id', $subtask->ticket_id)->first();
                        if ($ticket) {
                            $from_user = $ticket->from_id;
                          
                            $employee_position = \App\Models\EmployeePosition::where('id', $from_user)->first();
                            if ($employee_position) {
                                echo $employee_position->name . ' - ' . $employee_position->user->name;
                            }
                        }
                        @endphp
                     </td>
                <td>{{ $subtask->percentage }} %</td>
                <td> <a href="{{ url(env('APP_URL_REAL').'/mysubtasks-evidence/'.$subtask->id) }}" class="btn btn-info" target="_blank">الشواهد</a></td>
                                <td>
                                    @php
                                        // Get the ticket related to this subtask
                                        $sent_ticket = \App\Models\Ticket::where('id', $subtask->ticket_id)->first();
                                    @endphp
                                    @if($sent_ticket)
                                        <a href="{{ env('APP_URL_REAL') }}/ticketsshow/{{ $sent_ticket->id }}" target="_blank">عرض</a>
                                    @else
                                        <span class="text-muted">لا يوجد تذكرة</span>
                                    @endif
                                </td>

                <td>
                   
                    @if($admin ==1)
                    <button type="button" class="btn btn-primary button_change_satatus btn-sm d-inline" data-toggle="modal" data-target="#exampleModal" taskid="{{$subtask->id}}" taskname="{{$subtask->name}}">
                        <i class="fas fa-check"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal" data-taskid="{{ $subtask->id }}" data-taskname="{{ $subtask->name }}">
                        <i class="fas fa-times"></i>
                    </button>
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
            @endif
        </tbody>
    </table>
</div>


<!-- Modal for changing satus -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('subtask.status') }}">
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
                        <input type="range" id="pi_input" name="percentage2" min="0" max="100" value="0" step="10" />
                        <input type="hidden" id="pi_input2" name="percentage" min="0" max="100" value="0" step="10" />
                        <p>نسبة الإكتمال: <output id="value"></output></p>

                        <select class="form-control" id="taskStatus" name="task_status" required >
                            <option value="0">غير مكتمل</option>
                            <option value="2">مكتمل بشكل جزئي</option>
                            <option value="1">مكتمل</option>
                        </select>
<input type="hidden" name="taskid" value="{{ $subtask->id ?? '' }}" />

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

        <!-- Modal for rejection (used by reject button) -->
        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="{{ route('subtask.status') }}" id="rejectFormModal">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">رفض المهمة</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="taskid" id="rejectTaskIdModal" />
                            <input type="hidden" name="status" value="rejected" />
                            <div class="mb-3">
                                <h6 class="text-muted">المهمة: <span id="rejectTaskNameModal"></span></h6>
                            </div>
                            <div class="form-group">
                                <label for="rejectNotesModal">سبب الرفض <span class="text-danger">*</span></label>
                                <textarea name="notes" id="rejectNotesModal" class="form-control" rows="4" placeholder="يرجى كتابة سبب الرفض..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-danger">رفض المهمة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



<!-- DataTables assets are loaded in the layout; initialization is pushed to the scripts stack below -->



                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


document.addEventListener("DOMContentLoaded", function() {
    const taskStatus = document.querySelector("#taskStatus");
    const piInput = document.querySelector("#pi_input");
    const piInput2 = document.querySelector("#pi_input2");
    const valueDisplay = document.querySelector("#value");

    // Update the display and piInput status based on taskStatus
    function updateStatus() {
        const status = taskStatus.value;
        switch (status) {
            case "0":
                piInput.disabled = true;
                piInput.value = 0;
                piInput2.value = 0;
                break;
            case "2":
                piInput.disabled = false;
                piInput.value = 50;
                piInput2.value = 50;
                break;
            case "1":
                piInput.disabled = true;
                piInput.value = 100;
                piInput2.value = 100;
                break;
        }
        valueDisplay.textContent = piInput.value;
        piInput2.value = piInput.value;
    }

    // Initial check and update
    updateStatus();

    // Event listener for changes on taskStatus
    taskStatus.addEventListener("change", updateStatus);

    // Update display as the user types in pi_input
    piInput.addEventListener("input", (event) => {
        valueDisplay.textContent = event.target.value;
        piInput2.value = event.target.value;
    });
});





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

@push('scripts')
<script>
// Consolidated reject-modal handlers — run after layout loads jQuery/Bootstrap
function setRejectTaskId(id, name){
    $('#rejectTaskIdModal').val(id);
    $('#rejectTaskNameModal').text(name);
}



$(document).on('submit', '#rejectFormModal', function(e){
    e.preventDefault();
    var form = $(this);
    var btn = form.find('button[type="submit"]');
    var original = btn.html();
    btn.prop('disabled', true).html('جاري الارسال...');

    // Ensure task id is present (fallback to modal data or alternate input)
    var tid = $('#rejectTaskIdModal').val();
    if(!tid){
        tid = $('#rejectModal').data('taskid') || $('#rejectTaskId').val();
        if(tid){
            $('#rejectTaskIdModal').val(tid);
        }
    }

    console.log('Submitting reject form with data:', form.serialize());
    console.log('Task ID:', tid);

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(resp){
            var id = $('#rejectTaskIdModal').val() || $('#rejectModal').data('taskid') || $('#rejectTaskId').val();
            if(id){
                // Remove the table row with smooth animation
                $('#subtask-row-' + id).fadeOut(400, function(){
                    $(this).remove();
                    
                    // If DataTable is initialized, also remove from DataTable
                    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#approvalTable')) {
                        var table = $('#approvalTable').DataTable();
                        table.row('#subtask-row-' + id).remove().draw(false);
                    }
                    
                    // Check if table is now empty
                    if($('#approvalTable tbody tr').length === 0){
                        $('#approvalTable tbody').html('<tr><td colspan="9" class="text-center">لا توجد مهام للموافقة عليها.</td></tr>');
                    }
                });
            }
            $('#rejectModal').modal('hide');
            $('#rejectNotesModal').val('');
        },
        error: function(xhr){
            console.error('Reject request failed:', xhr);
            var errorMsg = 'حدث خطأ أثناء إرسال الطلب';
            if(xhr.responseJSON && xhr.responseJSON.message){
                errorMsg += '\n' + xhr.responseJSON.message;
            } else if(xhr.responseText){
                console.log('Response:', xhr.responseText);
            }
            alert(errorMsg);
        },
        complete: function(){
            btn.prop('disabled', false).html(original);
        }
    });
});

// Populate reject modal when shown via data attributes
$('#rejectModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget); // Button that triggered the modal
    var taskId = button.data('taskid');
    var taskName = button.data('taskname');
    if(taskId){
        $('#rejectTaskIdModal').val(taskId);
        $(this).data('taskid', taskId);
    }
    if(taskName){
        $('#rejectTaskNameModal').text(taskName);
    }
});

// Also handle direct clicks on any button that opens the reject modal (delegated)
$(document).on('click', 'button[data-target="#rejectModal"]', function(){
    var btn = $(this);
    var id = btn.data('taskid') || btn.attr('taskid');
    var name = btn.data('taskname') || btn.attr('taskname');
    if(id){
        $('#rejectTaskIdModal').val(id);
        $('#rejectTaskId').val(id);
        $('#rejectModal').data('taskid', id);
    }
    if(name){
        $('#rejectTaskNameModal').text(name);
        $('#rejectTaskName').text(name);
    }
});
</script>
@endpush
@push('scripts')
<script>
    (function(){
        // Initialize DataTable after layout scripts (jQuery/DataTables) are loaded
        try{
            console.log('approvalTable init. jQuery:', typeof $ === 'function' ? $.fn.jquery : 'n/a', 'DataTable present:', !!($.fn && $.fn.DataTable));
            if ($.fn && $.fn.DataTable) {
                $('#approvalTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    responsive: true,
                    pageLength: 25,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
                    }
                });
                console.log('DataTable initialized on #approvalTable');
            } else {
                console.error('DataTables plugin not loaded when initializing approvalTable.');
            }
        } catch (e) {
            console.error('Error initializing approvalTable DataTable:', e);
        }
    })();
</script>
@endpush
@endsection