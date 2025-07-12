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

    <x-page-heading :title="'إنشاء مؤشر كفاءة وفعالية'"  />

<form method="post" action="{{ route('moashermkmf.store') }}">
    @csrf
<div class="form-group">
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name"/>
</div>

<div class="form-group">
    <label for="name">المبادرات</label>
    <select  class="selectpicker "  data-live-search="true" name="mubadara" >
        @foreach ($mubadaras as $mubadara)
        <option value="{{ $mubadara->id }}" @if($mubadara->id == $_GET['mubadara']) selected @endif>{{ $mubadara->name }}</option>
        @endforeach
    </select>
    </div>


    <div class="form-group">
        <label for="name">النوع</label>
        <select  class="selectpicker"  data-live-search="true" name="type">
           <option value="mk">مؤشر كفاءة</option>
           <option value="mf">مؤشر فعالية</option>

        </select>
        </div>

 
<div class="form-group">
    <button class="btn-primary">حفظ</button>
</form>
</div>
@endsection