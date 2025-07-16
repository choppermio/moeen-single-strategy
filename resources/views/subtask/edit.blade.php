@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

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
    

<form method="post" action="{{ route('subtask.update', $subtask->id) }}">
        @csrf
        @method('PUT') {{-- Method spoofing to allow PUT request --}}
        
        <div class="form-group">
            <label for="name">الإسم:</label>
            <input type="text" class="form-control" name="name" value="{{ $subtask->name }}"/>
            {{-- Include validation feedback if needed --}}
        </div>

        <div class="form-group">
            <label for="task">المهمة الرئيسية</label>
            <select class="selectpicker" data-live-search="true" name="parent_id">
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}" {{ $subtask->parent_id == $task->id ? 'selected' : '' }}>{{ $task->name }}</option>
                @endforeach
            </select>
            {{-- Include validation feedback if needed --}}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">تحديث</button>
        </div>
    </form>


</div>

  
@endsection