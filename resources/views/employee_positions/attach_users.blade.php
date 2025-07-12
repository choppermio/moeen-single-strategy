@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<style type="text/css">
    .dropdown-toggle{
        height: 40px;
        width: 400px !important;
    }
</style>
<div class="container">
    <form action="{{env('APP_URL_REAL')}}/attach-users-store/{{ $position_id }}" method="post">
        @csrf
<div class="form-group">

<br />
<h4>{{ $employeeposition }}</h4>

<label for="name">الأعضاء الفرعيين تحت الإدارة</label>

<div class="form-group">
    <label for="name">النوع</label>
    @php
    // dd($position_id);
    $selectedEmployeePositions = \App\Models\EmployeePositionRelation::where('parent_id', $position_id)
                                                                 ->pluck('child_id')
                                                                 ->toArray();
        // dd($selectedEmployeePositions);
    @endphp
    <select multiple class="selectpicker" data-live-search="true" noneResultsText="لاتوجد نتائج مطابقة ل : {0}" name="employee_positions[]">
        @foreach ($employee_positions as $employee_position)
            <option value="{{ $employee_position->id }}"
                @if(in_array($employee_position->id, $selectedEmployeePositions)) selected @endif>
                {{ $employee_position->name }}
            </option>
        @endforeach
    </select>
    
    </div>

</div>
<div class="form-group">
    <button class="btn btn-primary">إرسال</button>
</form>
</div>

@endsection