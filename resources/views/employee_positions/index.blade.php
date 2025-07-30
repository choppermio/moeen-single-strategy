@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- bootstrap cdn-->
<div class="container-fluid pt-2">
    <h3>المناصب الوظيفية</h3>
    <hr />
    <a  href="{{url('/employeepositions/create')}}"><button class="btn btn-primary m-3">أضف جديد</button></a>

    <table class="table table-bordered" dir="rtl" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>المنصب</th>
                <th style="width:0px;">إسناد للإدارة</th>
                <th>الموظفين المدرجين تحت الإدارة</th>
                <th>الإحصائية الشهرية للإدارة</th>
                <th>الإحصائية السنوية للإدارة</th>
                <th>الإحصائية الشهرية للموظف</th>
                <th>الإحصائية السنوية للموظف</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employeepositions as $employeeposition)
            @php
                
            @endphp
            <tr>
                <td>
                    <span class="badge badge-info">{{ $employeeposition->name ??'' }} - {{ $employeeposition->user->name??'' }}</span>
                </td>
                <td>
                    @if(env('STRATEGY_CONTROL_ID') && in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
                        <a href="{{ url('attach-users/'.$employeeposition->id) }}" class="btn btn-secondary btn-sm">
                            <i class='fas fa-user'></i>
                        </a>
                    @endif

                </td>
                 <td>
                    @php
$employee_childrens = \App\Models\EmployeePositionRelation::where('parent_id', $employeeposition->id)->get();

// dd($employee_childrens);
// dd($employee_childrens);
// dd($employee_childrens) ;
@endphp

@if($employee_childrens->count() > 0)

                    @foreach ($employee_childrens as $employee_children) 
                       @php
                    //    dd($employee_children->child_id);
                    $EmployeePosition = \App\Models\EmployeePosition::where('id', $employee_children->child_id)->first();


                    //    dd($EmployeePosition);
                    
                    @endphp
                    <span class="badge badge-info">{{ $EmployeePosition->name }} - {{ $EmployeePosition->user->name }}</span>
                    
                    @if(env('STRATEGY_CONTROL_ID') && in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
                        <a href="{{ url('employee-position-delete/'.$employee_children->id) }}" class="btn btn-danger btn-sm " style="float:left;"><i class="fa fa-trash"></i></a>
                    @endif
                    <hr /> 

                    @endforeach
                 @endif
                </td>
                <td>
                    <a href="{{ url('/subtask-analyst?type=month&id='.date("m").'&department_id='.$employeeposition->id) }}">عرض</a>
                    </td>

                   <td>
                    <a href="{{ url('/subtask-analyst?type=year&id='.date("Y").'&department_id='.$employeeposition->id) }}">عرض</a>
                   
                   </td>
                <td>
                    <a href="{{ url('/subtask-analyst?type=month&id='.date("m").'&department_id='.$employeeposition->id) }}&solo=true">عرض</a>
                    </td>

                   <td>
                    <a href="{{ url('/subtask-analyst?type=year&id='.date("Y").'&department_id='.$employeeposition->id) }}&solo=true">عرض</a>
                   
                   </td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection