@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);
// dd($tasks);
@endphp

@section('content')

@php
// $file = \App\Models\Subtask::find(1)->getMedia('images');


@endphp
{{-- <a href="{{$file[0]->getUrl()}}">m</a> --}}
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
    <x-page-heading :title="'إنشاء مهمة لنفسي'"  />

<form method="post" action="{{ route('subtask.store') }}">
    @csrf
<div class="form-group">
    
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name"/>
</div>

<div class="form-group">
    <label for="name">المهمة الرئيسية</label>
    <select  class="selectpicker" data-live-search="true" name="task" >
        @php
       
        @endphp
        @foreach ($tasks as $task)
        <option value="{{ $task->id }}" >{{ $task->name }}</option>
        @endforeach
    </select>
    </div>

 
<div class="form-group">
    <button class="btn btn-primary">حفظ</button>
</form>
</div>
@endsection