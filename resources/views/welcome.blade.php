@extends('layouts.app')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<div class="container">
    


<style>body{direction:rtl;}</style>
@php


function levelCount($parent,$level){
    $level6_tasks =\App\Models\Todo::where('level',$level)->where('collection_id',$parent)->get();
        $count = 0;
        $countDone = 0;
        foreach($level6_tasks as $level6_task){

            if($level6_task->done == 1){
                $countDone++; 
            }else{
                $count++;
            }


        }
        $data = [
        'count' => $count,
        'countDone' => $countDone,
    ];
    return $data;

        // dd($count .'the done:'.$countDone);
    }
function level4($parent){

    $count = 0;
    $countDone = 0;
    

    $count +=levelCount($parent,5)['count'];
    $countDone +=levelCount($parent,5)['countDone'];
            // dd($count .'the done:'.$countDone);

    $percentage = ($countDone / $count) * 100;

    //dd();
    // $arrayData = $controller->getArrayData();
    
        //dd($count .'the done:'.$countDone);

}

// function return_percentage_level_4($bigless,$n,$parent){
//     $level6_tasks =\App\Models\Todo::where('level',5)->where('collection_id',$parent)->get();
//     foreach($level5ts as $level5)

//     endforeach

    

//         $level6_total_tasks =\App\Models\Todo::where('level',4)->where('collection_id',$parent)->count();
        
        
//        // dd($level6_total_tasks);
        
//         $level6_done_tasks =\App\Models\Todo::where('level','>',$n)->where('done',1)->count();
//                                     if ($level6_total_tasks > 0) {
//                                         $percentageDone = ($level6_done_tasks / $level6_total_tasks) * 100;
//                                         } else {
//                                         $percentageDone = 0;
//                                         }
//                                         return 'done with percentage  : '.$percentageDone.' %';       
//     }


//     function return_percentage($bigless,$n,$parent){
        
//         $level6_total_tasks =\App\Models\Todo::where('level',$bigless,$n)->where('collection_id',$parent)->count();
        
        
//        // dd($level6_total_tasks);
        
//         $level6_done_tasks =\App\Models\Todo::where('level','>',$n)->where('done',1)->count();
//                                     if ($level6_total_tasks > 0) {
//                                         $percentageDone = ($level6_done_tasks / $level6_total_tasks) * 100;
//                                         } else {
//                                         $percentageDone = 0;
//                                         }
//                                         return 'done with percentage  : '.$percentageDone.' %';       
//     }

@endphp



<ul>
@foreach($todos as $todo)

<li>{{$todo->task}} | {{$todo->done_percentage}}%</li>
    @php $level2 = \App\Models\Todo::where('level',2)->where('collection_id',$todo->id)->get(); @endphp
    <ul>
    @foreach($level2 as $todo_level2)
    <li><span class="badge bg-primary">{{$todo_level2->task}} | {{$todo_level2->done_percentage}}% </span>
       
        
        @php
        // dd($k);
        $moasherstragies = \App\Models\Todo::find(4)->moasheradastrategies;

    @endphp
    
    @foreach($moasherstragies as $moasherstrategy)
    <span class="badge bg-secondary"> {{ $moasherstrategy->name }}</span>
@endforeach
        @php $level3 = \App\Models\Todo::where('level',3)->where('collection_id',$todo_level2->id)->get(); @endphp
        <ul>
        @foreach($level3 as $todo_level3)
        <li><span class="badge bg-secondary">{{$todo_level3->task}}| {{$todo_level3->done_percentage}}%</span>
         


@php
$moashermkmfs = \App\Models\Todo::find(10)->moashermkmfs;

@endphp

@foreach($moashermkmfs as $moashermkmf)
<span class="badge bg-secondary"> {{ $moashermkmf->name }}</span>
@endforeach
        @endforeach
            @php $level4 = \App\Models\Todo::where('level',4)->where('collection_id',$todo_level3->id)->get(); @endphp
            <ul>
            @foreach($level4 as $todo_level4)
            <li>  @php 
            // dd($todo_level4->id);
            // dd(\App\Models\Todo::where('collection_id',6)->first()->countChildrenWithLevelGreaterThan(4));
              //  echo \App\Models\Todo::where('collection_id',$todo_level4->id)->first()->countChildrenWithLevelGreaterThan(4)['percentageDone'].' %';
                @endphp 
                {{-- <span class="badge bg-warning">{{$todo_level4->task}} | {{$todo_level4->done_percentage}}%</span> --}}
             
            @php 
            // dd(level4($todo_level4->id));
            @endphp
               
            @php                               
            //  echo  return_percentage('>',4,$todo_level4->id);
            @endphp
                @php $level5 = \App\Models\Todo::where('level',5)->where('collection_id',$todo_level4->id)->get(); @endphp
                    <ul>
                    @foreach($level5 as $todo_level5)

                    @php
                     
                    @endphp
                    <li><span class="badge bg-info">{{$todo_level5->task}} | {{$todo_level5->done_percentage}}%</span>

                        @php
                        //get from moasher model where id= $todo_level4->id
                        // dd($todo_level5->id);
                        $count_mosaher = \App\Models\Moasher::where('task_id',$todo_level5->id)->count()>0;
                        if($count_mosaher>0){

                                $moasher =\App\Models\Moasher::where('task_id',$todo_level5->id)->first();
                                // dd($moasher);
                                $moasher_kafaa_name =\App\Models\Todo::where('id',$moasher->moasher_kafaa_id)->first();
                                $moasher_fa3lia_name =\App\Models\Todo::where('id',$moasher->moasher_fa3lia_id)->first();
                        }

                        
        @endphp
@if($count_mosaher>0)
    <span class="badge bg-warning">مؤشر كفاءة :{{$moasher_kafaa_name->task}} | {{$moasher_kafaa_name->done_percentage}}%</span>
    <span class="badge bg-warning">مؤشر فعالية :{{$moasher_fa3lia_name->task}} | {{$moasher_fa3lia_name->done_percentage}}%</span>
    <button type="button" class="btn btn-primary button_add_task btn-sm" data-bs-toggle="modal" data-bs-target="#addtaskModal" taskid="{{$todo_level5->id}}" taskname="{{$todo_level5->task}}">
        <i class="fas fa-add"></i>
    </button>
                     @endif
                     
                     
                     @php 
                            //    echo  return_percentage('>',5,$todo_level5->id);

                        @endphp
                                @php 
                                   // dd($level6_call::count());
                                    $level6 = \App\Models\Todo::where('level',6)->where('collection_id',$todo_level5->id)->get(); @endphp
                            <ul>
                               @php 
                             @endphp
                            @foreach($level6 as $todo_level6)
                            <li><span class="badge bg-dark">{{$todo_level6->task}}   | {{$todo_level6->done_percentage}}%</span>
                            {{-- bootstrap button with edit fontawesome icon --}}
                            {{-- <a href="" class="btn btn-sm btn-primary"><i class="fas fa-check"></i></a> --}}

                            <button type="button" class="btn btn-primary button_change_satatus btn-sm" data-bs-toggle="modal" data-bs-target="#taskModal" taskid="{{$todo_level6->id}}" taskname="{{$todo_level6->task}}">
                                <i class="fas fa-check"></i>
                            </button>


                            {{-- bootstrap button with delete fontawesome icon --}}
                            
                            </li>

                            @endforeach
                            </ul>
                    
                    </li>

                    @endforeach
                    </ul>
            </li>

            @endforeach
            </ul>
        </ul>
    </li>
    @endforeach
    </ul>
    </li>
       
@endforeach
</ul>
</div>








<!-- Modal for add todo -->
<div class="modal_add_task modal fade" id="addtaskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('todo.add') }}">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">إضافة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
                    @csrf
                    <div class="mb-3">
                        <h2 class="form-label taskname"></label>
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">اسم المهمة</label>
                        <input type="text" name="task" id="taskStatus" value="" placeholder="أضف إسم المهمة">
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









<!-- Modal for changing satus -->
<div class="modal_change_satatus modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('todo.update') }}">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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




@endsection


