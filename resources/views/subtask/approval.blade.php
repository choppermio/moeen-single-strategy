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
<div class="container">
    <x-page-heading :title="'الموافقة على المهام'"  />

    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>المهمة</th>
                <th>نسبة الإكتمال</th>
                <th>الشواهد</th>
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

                    // dd($subtasks);
                    
                    
                    @endphp
            @foreach ($subtasks as $subtask)
            <tr>
                @php
                $task = \App\Models\Task::where('id', $subtask->parent_id)->first();
                
                    $mubadara_info = \App\Models\Mubadara::where('id', $task->parent_id)->first();
                
            @endphp



                <td>{{ $subtask->name }}
                    <div>     <span class="badge badge-secondary">مبادرة : {{ $mubadara_info->name }} ({{ \App\Models\EmployeePosition::where('id', $mubadara_info->user_id)->first()->name }})</span><br />
                         <span class="badge badge-info">الإجراء الرئيسي : {{ $task->name }} ({{ \App\Models\EmployeePosition::where('id', $task->user_id)->first()->name }})</span>
                     </div>
                     
                     </td>
                <td>{{ $subtask->percentage }} %</td>
                <td> <a href="{{ url(env('APP_URL_REAL').'/mysubtasks-evidence/'.$subtask->id) }}" class="btn btn-info" target="_blank">الشواهد</a></td>
                <td>
                   
                    @if($admin ==1)
                    <button type="button" class="btn btn-primary button_change_satatus btn-sm d-inline" data-toggle="modal" data-target="#exampleModal" taskid="{{$subtask->id}}" taskname="{{$subtask->name}}">
                        <i class="fas fa-check"></i>
                    </button>

                    <form method="post" action="{{route('subtask.status')}}" class="d-inline">
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





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
@endsection