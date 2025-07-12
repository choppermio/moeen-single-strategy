@extends('layouts.admin')

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

    <x-page-heading :title="'تعديل مؤشر كفاءة وفعالية'"  />

    <!-- Change the action to point to the update route, assuming you have the indicator's ID -->
    <form method="post" action="{{ route('moashermkmf.update', $moashermkmf->id) }}">
        @csrf
        @method('PUT') <!-- Include this to simulate a PUT request -->

        <div class="form-group">
            <label for="name">الإسم:</label>
            <!-- Pre-fill the name -->
            <input type="text" class="form-control" name="name" value="{{ $moashermkmf->name }}"/>
        </div>
{{-- 
        <div class="form-group">
            <label for="name">المبادرات</label>
            <select class="selectpicker" data-live-search="true" name="mubadara">
                @foreach ($mubadaras as $mubadara)
                <option value="{{ $mubadara->id }}" {{ $moashermkmf->mubadara_id == $mubadara->id ? 'selected' : '' }}>{{ $mubadara->name }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="form-group">
            <label for="name">النوع</label>
            <select class="selectpicker" data-live-search="true" name="type">
               <option value="mk" {{ $moashermkmf->type == 'mk' ? 'selected' : '' }}>مؤشر كفاءة</option>
               <option value="mf" {{ $moashermkmf->type == 'mf' ? 'selected' : '' }}>مؤشر فعالية</option>
            </select>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">تحديث</button>
        </div>
    </form>
</div>
@endsection
