@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- Bootstrap Select CSS - matching the JS version 1.13.14 loaded in admin layout -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css" />
<!-- Note: jQuery, Bootstrap JS, and Bootstrap Select JS are already loaded in admin.blade.php -->
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

<script>
// Wait for all libraries to load, then initialize Bootstrap Select
$(window).on('load', function() {
    setTimeout(function() {
        // Destroy any existing Bootstrap Select instances first
        $('.selectpicker').selectpicker('destroy');
        
        // Initialize Bootstrap Select fresh
        $('.selectpicker').selectpicker({
            liveSearch: true,
            noneResultsText: 'لا توجد نتائج مطابقة ل: {0}',
            style: 'btn-outline-secondary',
            size: 10
        });
    }, 100);
});
</script>

@endsection