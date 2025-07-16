@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- bootstrap cdn-->
<div class="container pt-2">
    <h3>تحت الإدارة</h3>
    <hr />
    <a  href="{{url('/employeepositions/create')}}" class="d-none"><button class="btn btn-primary m-3">أضف جديد</button></a>

    <table class="table table-bordered" dir="rtl" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>المنصب</th>
                
                <th>الإحصائية الشهرية</th>
                <th>الإحصائية السنوية</th>
                <th>الإحصائية الشهرية للإدارة</th>
                <th>الإحصائية السنوية للإدارة</th>
                <th>المهام</th>
                <th>التقويم</th>
                
                
            </tr>
        </thead>
        <tbody>
            
            @foreach ($employeepositions as $employeeposition)
            @php
                
            @endphp
            <tr>
                <td>{{ $employeeposition->name }} -                 {{ $employeeposition->user->name }}
                </td>
               <td>
                <a href="{{ url('/subtask-analyst?type=month&id='.date("m").'&user_id='.$employeeposition->id) }}">عرض</a>
               </td>
                 
               <td>
                <a href="{{ url('/subtask-analyst?type=year&id='.date('Y').'&user_id='.$employeeposition->id.'&user_id='.$employeeposition->id) }}">عرض</a>
               </td>
               <td>
                <a href="{{ url('/subtask-analyst?type=month&id='.date("m").'&department_id='.$employeeposition->id) }}">عرض</a>
                </td>

               <td>
                <a href="{{ url('/subtask-analyst?type=year&id='.date("Y").'&department_id='.$employeeposition->id) }}">عرض</a>
               
               </td>
               <td>
                <a href="{{ url('/mysubtasks?show-as-admin=t&id='.$employeeposition->id) }}">عرض</a>
               </td>
               <td>
              
                <a href="{{  url('/mysubtaskscalendar?user='.$employeeposition->id) }}">عرض</a>
               </td>

               


            </tr>
            @endforeach
        </tbody>
    </table>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection