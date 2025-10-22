
@extends('layouts.admin')
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
@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);
// $subtasks  = $completed_subtasks;
//             dd($subtasks);
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
@section('content')
@php
// $admin =isset($_GET['approve']) 1:0;
// $user_id  = auth()->user()->id;
if(isset($_POST['approve'])){
    $admin=1;
    
    $subtasks = \App\Models\Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->where('status', 'pending-approval','rejected')->get();
    
}else{
       $subtasks = \App\Models\Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->whereIn('status',[ null,'pending','rejected','NULL','approved' ])->get();

    $admin=0;
}
@endphp
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--fontawesome cdn-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<div class="container-fluid">
    <x-page-heading :title="'مهامي'"  />
    <a href="{{ env('APP_URL_REAL').'/tickets/create?myself=1' }}" class="btn btn-primary">إضافة مهمة لنفسي </a>
    <br />

    <!--<a href="" class="btn btn-primary">أضف مهمة جديدة</a>-->
{{-- Assuming Bootstrap is properly included in your project --}}
<ul class="nav nav-tabs mt-4" id="myTab" role="tablist" style="margin-top:1em; padding:0px;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab" aria-controls="current" aria-selected="true">الحالية</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">قيد المراجعة</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">المكتملة</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent" style="overflow:auto;">
    <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
        @include('components.subtasksTable', ['subtasks' => $subtasks, 'children_employee_positions' => $children_employee_positions,'no_evidence'=>0])
    </div>
    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
        @php
            $subtasks  = $pending_subtasks;
           
            // dd($subtasks)
        @endphp
            @include('components.subtasksTable', ['subtasks' => $completed_subtasks, 'children_employee_positions' => $children_employee_positions,'no_evidence'=>0])
      
    </div>
    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
        @php
            $subtasks  = $completed_subtasks;
         
        @endphp
        @include('components.subtasksTable', ['subtasks' => $pending_subtasks, 'children_employee_positions' => $children_employee_positions,'no_evidence'=>0])
    </div>
</div>

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





<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <input type="hidden" name="typo" value="subtask">
            <div class="form-group">
              <label for="exampleFormControlSelect1">اختيار الموظفين (يمكنك اختيار أكثر من موظف)</label>
              <select class="form-control" name="user_ids[]" id="exampleFormControlSelect1" multiple size="6">
                @php
                $all_employees = \App\Models\EmployeePosition::with('user')->get();
                @endphp
                @foreach ($all_employees as $employee)
                @if($employee->user)
                <option value="{{$employee->id}}">{{$employee->name}} - {{$employee->user->name}}</option>
                @endif
                @endforeach
              </select>
              <small class="form-text text-muted">اضغط Ctrl + Click لاختيار أكثر من موظف</small>
              <br>
              <button type="submit" class="btn btn-primary">حفظ</button>

            </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

//make the javascript code that when i press the modal button it gets the subtask_id and put it in the hidden feild as a value
<script>
    $(document).ready(function(){
        $('.button-change-status').click(function(){
            var subtask_id = $(this).attr('subtask');
            $('input[name="subtask_id"]').val(subtask_id);

        });
    });
    </script>

    
<script>
    $(document).ready(function() {
        $('#changetaskform').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    // Handle the successful response here
                    alert('تم التعديل');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle the error response here
                    alert('An error occurred!');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>



<script>
  $('.button-change-user').click(function(){
        var subtaskid = $(this).attr('subtask');
        $('input[name="subtaskid"]').val(subtaskid);
        
        // Clear previous selections
        $('#exampleFormControlSelect1 option:selected').prop('selected', false);
        
        // Fetch current assignments and pre-select them
        $.ajax({
            url: '{{ route("subtask.getAssignments") }}',
            type: 'GET',
            data: { 
                type: 'subtask',
                id: subtaskid 
            },
            success: function(response) {
                console.log('Current assignments:', response);
                
                // Pre-select the currently assigned employees
                if (response && response.length > 0) {
                    response.forEach(function(assignment) {
                        $('#exampleFormControlSelect1 option[value="' + assignment.employee_position_id + '"]').prop('selected', true);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching assignments:', error);
                // Clear selections on error
                $('#exampleFormControlSelect1 option:selected').prop('selected', false);
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
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
@endsection