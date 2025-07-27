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

<script>
// Wait for all libraries to load, then initialize Bootstrap Select
$(window).on('load', function() {
    setTimeout(function() {
        // Destroy any existing Bootstrap Select instances first
        $('.selectpicker').selectpicker('destroy');
        
        // Initialize Bootstrap Select fresh
        $('.selectpicker').selectpicker({
            liveSearch: true,
            style: 'btn-outline-secondary',
            size: 10
        });
    }, 100);
});
</script>

@endsection