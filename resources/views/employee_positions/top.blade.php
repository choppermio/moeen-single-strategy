@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<div class="container mt-5">

@if (!empty($current_employee_score))
<h4 style="color: black; background:white; border:3px dashed orange; text-align:center;">
    <p>المنصب الوظيفي للموظف: {{ $current_employee_score[0]['employee_position']->name }}</p>
    <p>النسبة: {{ floor($current_employee_score[0]['percentage']) }}</p>
</h4>
@endif
    <h2 class="text-center mb-4">
        جدول أفضل 5 موظفين بناءً على نسبة المهام المكتملة في الربع 
        {{ \Carbon\Carbon::now()->quarter }} 
        لسنة 
        {{ \Carbon\Carbon::now()->year }}
    </h2>    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">اسم الموظف</th>
                <th scope="col">الوظيفة</th>
           
                <th scope="col">النسبة المئوية</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($top_5_employees as $index => $employee)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $employee['employee_position']->user->name }}</td>
                    <td>{{ $employee['employee_position']->name }}</td>
                   
                    <td>{{ number_format($employee['percentage'], 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('subtask.mysubtasks') }}"><button class="btn btn-info" style="text-align: center; width:100%">الذهاب الى مهامي</button></a>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>