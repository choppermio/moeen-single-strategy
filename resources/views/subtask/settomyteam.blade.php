@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<!-- Bootstrap Select CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css" />
<style>
  .btn-ss {
    padding: 0px 5px;
    margin: 0px 5px;
  }
  .dropdown-toggle {
    height: auto !important;
    min-height: 40px;
  }
  .bootstrap-select .dropdown-menu {
    max-height: 300px;
    overflow-y: auto;
  }
</style>
<div class="container">

  <x-page-heading :title="'إسناد لفريقي'"  />

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif


  
    @foreach ($mubadaras as $mubadara)
    <div style="background: white; border:1px dotted rgb(212, 212, 212); margin:1em;padding:1em;">
    <h3>{{$mubadara->name}}</h3>
    <ul >
        @php
            $moashermkmfs = \App\Models\Moashermkmf::where('parent_id',$mubadara->id)->get();
            // dd($moashermkmfs);
    //object variable empty
    $emptyObject = [];
$uniqueTasks = []; // An associative array to store unique tasks

foreach ($moashermkmfs as $moashermkmff) {
    if ($moashermkmff->tasks->count() != 0) {
        // dd($moashermkmff->tasks);
        foreach ($moashermkmff->tasks as $task) {
            // dd($task);
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
// dd($uniquetasks);
    // $tasks = $uniqueTasks;
        @endphp

        <ul >
        @foreach ($uniqueTasks as $tasko)
        @if(!isset($tasko))
        @continue
        @endif
        @php
        // dd($tasko);
        @endphp
        <li >
          @php
          $employee_task_position = \App\Models\EmployeePosition::where('id', $tasko['user_id'])->first();

          // Display task name and original assignment
          if ($employee_task_position) {
              echo $tasko['name'] . '';
              echo ' <span class="badge badge-secondary">مخرج الإجراء' . $tasko['output'] . '</span>';
          } else {
              echo e($tasko['name'] . ' ');
          }
          @endphp
          @if($tasko['hidden'] == 1)
            <span class="badge badge-warning">مهمة متوقفة </span>
          @endif
          <br>
              <button style="display:inline-block" type="button" subtask="{{$tasko['id']}}" typo="task" class="btn btn-primary   button-change-user btn-sm btn-ss" data-toggle="modal" data-target="#exampleModal">
              <i class="fas fa-user"></i>
            </button>
         <div style="    display: inline-block;"> <x-assigned-users :type="'task'" :id="$tasko->id" />
        </div>
           
        
            @php
            $subtasks = \App\Models\Subtask::where('parent_id',$tasko->id)->get();
            @endphp
            <li>
              <span style="cursor: pointer;">اظهار المهام الفرعية</span>
            <ul style="display: none;">
            @foreach ($subtasks as $subtask)
            @php
              $employee_position = \App\Models\EmployeePosition::where('id',$subtask->user_id)->first();
            @endphp
              <li>{{$subtask->name}} <span class="badge badge-info">
                @if($employee_position)
                  {{$employee_position->name}} - {{$employee_position->user->name}}
                @else
                  غير مسند
                @endif
              <br>
            
              </li>                
            @endforeach
            </ul>
        
        </li>
        @endforeach
    </ul>
    </ul>
  </div>
    @endforeach
</div>







<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">إسناد لموظف</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('subtask.settomyteamform')}}">
            @csrf
            <input type="hidden" name="subtaskid" value="">
            <div class="form-group">
              <label for="exampleFormControlSelect1">اختيار المناصب المسندة إليها (يمكنك اختيار أكثر من منصب)</label>
              <select class="selectpicker" name="user_ids[]" id="exampleFormControlSelect1" multiple data-live-search="true" data-size="8" title="اختر المناصب...">
                <option value="{{ current_user_position()->id }}">
                  نفسي - {{ current_user_position()->name }}
                </option>
                @foreach ($all_employees as $employee)
                @if($employee->user && $employee->id != current_user_position()->id)
                <option value="{{$employee->id}}" class="employee-option">
                  {{$employee->name}} - {{$employee->user->name}}
                </option>
                @endif
                @endforeach
              </select>
              <small class="form-text text-muted">يمكنك البحث في القائمة واختيار أكثر من منصب</small>
              <input type="hidden" name="typo" value="">
              <br><br>
              <button type="submit" class="btn btn-primary btn-block">إسناد للمناصب المختارة</button>
            </div>

            </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


@endsection

@push('scripts')
<!-- Bootstrap Select JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Bootstrap Select
    $('.selectpicker').selectpicker({
        noneSelectedText: 'لم يتم اختيار أي منصب',
        selectedTextFormat: 'count > 2',
        countSelectedText: function (numSelected, numTotal) {
            return numSelected + ' مناصب مختارة';
        }
    });

    // Ensure selectpicker is initialized after page load
    setTimeout(function() {
        $('.selectpicker').selectpicker('refresh');
    }, 100);

    $('.button-change-user').click(function(){

        var subtaskid = $(this).attr('subtask');
        var typoid = $(this).attr('typo');
        
        // Set the hidden fields
        $('input[name="subtaskid"]').val(subtaskid);
        $('input[name="typo"]').val(typoid);
        
        // Clear previous selections
        $('.selectpicker').selectpicker('deselectAll');
        
        // Fetch current assignments and pre-select them
        $.ajax({
            url: '{{ route("subtask.getAssignments") }}',
            type: 'GET',
            data: { 
                type: typoid,
                id: subtaskid 
            },
            success: function(response) {
                console.log('Current assignments:', response);
                
                // Pre-select the currently assigned employees
                if (response && response.length > 0) {
                    var assignedIds = response.map(function(assignment) {
                        return assignment.employee_position_id.toString();
                    });
                    
                    // Select the assigned employees in the dropdown
                    $('.selectpicker').selectpicker('val', assignedIds);
                } else {
                    // If no assignments found, clear all selections
                    $('.selectpicker').selectpicker('deselectAll');
                }
                
                // Refresh the selectpicker to show the new selections
                $('.selectpicker').selectpicker('refresh');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching assignments:', error);
                // Clear selections on error
                $('.selectpicker').selectpicker('deselectAll');
                $('.selectpicker').selectpicker('refresh');
            }
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

}); // Close $(document).ready()
</script>
@endpush