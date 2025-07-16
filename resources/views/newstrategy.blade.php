@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

function get_user_name($id){
    return \App\Models\EmployeePosition::find($id)->name ?? 'غير محدد';
}
@endphp

@section('content')

@php
// $user_id  =  auth()->user()->id;
// if($user_id != \App\Models\Hadafstrategy::where('id',$_GET['id'])->first()->user_id || $user_id != 1){
//     dd('not allowed');
// }
if(!isset($_GET['id'])){
    $_GET['id'] = 999999999999999;
}
@endphp
<style>
    .button{display:none !important;}
    
</style>
                    @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
<style>
    .button{display:inline-block !important;}
    
</style>
@endif
<script src="https://kit.fontawesome.com/2c740d50fa.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@php
    $hadafstrategies = \App\Models\Hadafstrategy::where('id',$_GET['id'])->get();
  
@endphp
<style>
    /* body{direction: rtl;} */
    ul{text-align: right;}
.padding-sm-button{
    padding: 1px 5px;
    font-size: 10px;
}
</style>
<div class="container">
       
    <x-page-heading :title="'بناء الهدف الإستراتيجي'"  />

    <a href="{{url('/hadafstrategies/create')}}" target="_blank"><button class="btn btn-primary btn-sm button" >أضف هدف استراتيجي</button></a>
<a href="{{env("APP_URL_REAL")  }}/mubadara/create?hadafstrategy={{$_GET['id']}}" target="_blank"><button class="btn btn-secondary btn-sm padding-sm-button button">أضف مبادرة</button></a>

<hr />
    <ul dir="rtl" class="" style="    line-height: 43px;">
@foreach ($hadafstrategies as $hadafstrategy )
<li>
<b>{{ $hadafstrategy->name }} </b> | <span class="badge badge-success">{{ $hadafstrategy->percentage }} %  </span>

<a href="{{env("APP_URL_REAL")  }}/moasheradastrategy/create?selected={{$hadafstrategy->id}}"    target="_blank">
    <button class="btn btn-secondary btn-sm padding-sm-button button"  data-toggle="tooltip" data-placement="top" title="أضف مؤشر استراتيجي "><i class="fa-solid fa-plus" ></i></button>
</a>


@php
    $mobadara_lists = \App\Models\Mubadara::where('hadafstrategy_id',$hadafstrategy->id)->get();

@endphp

<ul >
@foreach ($mobadara_lists as $mobadara_list )
<li>
<b>{{ $mobadara_list->name }} </b><span class="badge badge-secondary">{{ get_user_name($mobadara_list->user_id) }}</span> | <span class="badge badge-success">نسبة اكتمال : {{ $mobadara_list->percentage }} %</span> 
<a href="{{env("APP_URL_REAL")  }}/task/create?mubadara={{$mobadara_list->id}}" target="_blank">
    <button class="btn btn-secondary btn-sm padding-sm-button button" data-toggle="tooltip" data-placement="top" title="أضف إجراء رئيسي"><i class="fa-solid fa-plus" ></i></button>
</a>

<a href="{{env("APP_URL_REAL")  }}/moashermkmf/create?mubadara={{$mobadara_list->id}}" target="_blank">
    <button class="btn btn-secondary btn-sm padding-sm-button button" data-toggle="tooltip" data-placement="top" title="أضف مؤشر كفاءة وفعالية"><i class="fa-solid fa-plus" ></i></button>
</a>
{{-- @foreach ($mobadara_list->moasheradastrategies as $moasheradastrategy)
    <span class="badge badge-warning">{{ $moasheradastrategy->name }} {{ $moasheradastrategy->percentage }}%</span>
@endforeach --}}
<button class=" btn-info btn-sm padding-sm-button " style="display: inline-block;" data-toggle="collapse" data-target="#moasheradastrategies-{{ $mobadara_list->id }}">المؤشرات</button>
<div id="moasheradastrategies-{{ $mobadara_list->id }}" class="collapse">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>المؤشر</th>
                <th>نسبة الإكتمال</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mobadara_list->moasheradastrategies as $moasheradastrategy)
                <tr>
                    <td>{{ $moasheradastrategy->name }}</td>
                    <td><span class="badge badge-success">{{ $moasheradastrategy->percentage }}%</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@php
    $moashermkmfs = \App\Models\Moashermkmf::where('parent_id',$mobadara_list->id)->get();
    //object variable empty
    $emptyObject = [];
$uniqueTasks = []; // An associative array to store unique tasks

foreach ($moashermkmfs as $moashermkmff) {
    if ($moashermkmff->tasks->count() != 0) {
        foreach ($moashermkmff->tasks as $task) {
            $taskId = $task->id; // Assuming 'id' is the unique identifier property
            // Check if the task with this ID is not already in the uniqueTasks array
            if (!isset($uniqueTasks[$taskId])) {
                $uniqueTasks[$taskId] = $task;
            }
        }
    }
}

// Convert the associative array back to a sequential array if needed
$uniquetasks = array_values($uniqueTasks);

@endphp




<ul>
@php
    $is=0;
@endphp
    @foreach($uniquetasks as $uniquetask)
    <li style="    background: #ffffff;
    border: dotted 3px #e1e1e1;
    padding: 8px;">{{ $uniquetask->name }} <span class="badge badge-secondary">{{ get_user_name($uniquetask->user_id)  }}</span> | <span class="badge badge-success">{{ $uniquetask->percentage }} % </span>
        
<a href="{{env("APP_URL_REAL")  }}/subtask/create?task={{$uniquetask->id}}" target="_blank">
    <button class="btn btn-secondary btn-sm padding-sm-button button" data-toggle="tooltip" data-placement="top" title="أضف مهمة فرعية"><i class="fa-solid fa-plus" ></i></button>
</a>
        @php
   
        @endphp
        <button class="btn btn-info btn-sm padding-sm-button" data-toggle="collapse" data-target="#moashermkmfs-{{ $uniquetask->id }}">مؤشرات الكفاءة والفاعلية</button>
        <div id="moashermkmfs-{{ $uniquetask->id }}" class="collapse">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>المؤشر</th>
                        <th>النسبة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uniquetask->moashermkmfs as $taskmkmf)
                        <tr>
                            <td>{{ $taskmkmf->name }}**</td>
                            <td><span class="badge badge-info">{{ $taskmkmf->percentage }}%</span> 
                            
                            <form class="remove-task-form" data-id="{{ $taskmkmf->id }}" data-task="{{ $uniquetask->id }}">
    @csrf
    <button type="submit" class="btn btn-danger">x</button>
</form>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @php
        $subtasks = \App\Models\Subtask::where('parent_id',$uniquetask->id)->get();
   @endphp

   @if( $subtasks->count() > 0)
    <button class="btn btn-info btn-sm padding-sm-button" data-toggle="collapse" data-target="#subtasks-{{ $uniquetask->id }}">المهام</button>
    <div id="subtasks-{{ $uniquetask->id }}" class="collapse">
        <ul>
            @foreach ($subtasks as $subtask)
                <li>
                    {{ $subtask->name }}  | {{ $subtask->percentage }} %
                    <button type="button" class="btn btn-primary button_change_satatus btn-sm d-none" data-toggle="modal" data-target="#exampleModal" taskid="{{$subtask->id}}" taskname="{{$subtask->name}}">
                        <i class="fas fa-check"></i>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    </li>
@endforeach
    {{-- @foreach ($moashermkmfs as $moashermkmf)
        <li>
            {{ $moashermkmf->name }}  | {{ $moashermkmf->percentage }} %

            @php
            $tasks = $moashermkmf->tasks;
            // dd($tasks);
       @endphp
       <ul>
           @foreach ($tasks as $task)
               <li>
                   {{ $task->name }}  | {{ $task->percentage }} %  
                   
                   @foreach ($task->moashermkmfs as $taskmkmf)
                   <span style="background:yellow;">{{ $taskmkmf->name }}</span>
               @endforeach

                   @php
                   $subtasks = \App\Models\Subtask::where('parent_id',$task->id)->get();
              @endphp
                <ul>
                     @foreach ($subtasks as $subtask)
                       <li>
                            {{ $subtask->name }}  | {{ $subtask->percentage }} %
                       </li>
                     @endforeach
                   </ul>

               </li>
           @endforeach
       </ul>

       
        </li>
        
    @endforeach --}}
</ul>
@php
@endphp
</li>
@endforeach
</ul>



<br />
@endforeach
</ul>

<div class="row">
    <div class="col-6">
        
        
        <h6>مؤشرات الأداء الاستراتيجي</h6>
        <hr />
        @php
            // Assuming you have sanitized and validated the input
            $parentId = (int)$_GET['id']; // Using Laravel's request helper for better security
            // dd($parentId);
            $items = \App\Models\Moasheradastrategy::where('parent_id', $parentId)->get();
        @endphp
        
        @if($items->isNotEmpty())
            <ul style="font-size: 13px; background:e1e1e1;">
                @foreach($items as $item)
                    <li>{{ $item->name }}</li> <!-- Assuming 'name' is the field you want to display -->
                @endforeach
            </ul>
        @else
            <p>No items found.</p>
        @endif
        

    </div>
    <div class="col-6">
        <h6>مؤشرات الكفاءة والفعالية</h6>
        <hr />
        
@php
// Use Laravel's request helper for safer access to query parameters
$mubadaraId = $parentId;
$mubadara = \App\Models\Mubadara::where('hadafstrategy_id', $mubadaraId)->first();

$moashermkmfs = collect();
if ($mubadara) {
    $moashermkmfs = \App\Models\Moashermkmf::where('parent_id', $mubadara->id)->get();
}
@endphp

@if($moashermkmfs->isNotEmpty())
<ul style="font-size: 13px; background:#e1e1e1;">
    @foreach($moashermkmfs as $moashermkmf)
        <li>{{ $moashermkmf->name }}</li> {{-- Assuming 'name' is the column you want to display --}}
    @endforeach
</ul>
@else
<p>No related items found.</p>
@endif
    </div>
</div>
<hr />






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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<script>
$(document).ready(function () {
    $('.remove-task-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let moashermkmf_id = form.data('id');
        let task_id = form.data('task');
        let csrfToken = form.find('input[name="_token"]').val();

        $.ajax({
            url: '{{route("removetaskmkmf")}}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                moashermkmf_id: moashermkmf_id,
                task_id: task_id
            },
            success: function (response) {
                // Hide the tr (grandparent of the button)
                form.parent().parent().hide();
            },
            error: function () {
                alert('Failed to remove task.');
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

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


<!-- Button trigger modal -->

  @endsection
