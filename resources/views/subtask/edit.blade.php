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