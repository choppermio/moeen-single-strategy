@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<div class="container">
    <x-page-heading :title="'تعديل مبادرة'"  />

    <form method="post" action="{{ route('mubadara.update', ['mubadara' => $mubadara->id]) }}">
        @csrf
        {{ method_field('PUT') }}
    <div class="form-group">
    <label for="name">الإسم:</label>
    <input type="text" class="form-control" name="name" value="{{ $mubadara->name }}" required />
    </div>
    
    {{-- <div class="form-group">
        <label for="name">المؤشر الإستراتيجي</label>
        <select  class="selectpicker" multiple data-live-search="true" name="hadafstrategy[]">
            @foreach ($moasheradastrategies as $moasheradastrategy)
            <option value="{{ $moasheradastrategy->id }}">{{ $moasheradastrategy->name }}</option>
            @endforeach
        </select>
        </div> --}}
    
     
    
        <label for="name">إسناد لعضو:</label>
        <select  class=""  data-live-search="true" name="user_id">
            @foreach ($users as $user)
            <option value="{{ $user->id }}" @if($mubadara->user_id == $user->id) selected @endif>{{ $user->name }} - {{$user->user->name}}</option>
            @endforeach
        </select>
    </div>
    
    <div class="container">
        <div class="mb-3">
            <label for="general_desc" class="form-label">وصف عام</label>
            <textarea  class="form-control" id="general_desc" name="general_desc"  required>{{ $mubadara->general_desc }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="date_from" class="form-label">التاريخ من</label>
            <input type="date" class="form-control" id="date_from" name="date_from" required value="{{ $mubadara->date_from }}">
        </div>
        
        <div class="mb-3">
            <label for="date_to" class="form-label">التاريخ الى</label>
            <input type="date" class="form-control" id="date_to" name="date_to" required value="{{ $mubadara->date_to }}">
        </div>
        
        <div class="mb-3">
            <label for="estimate_cost" class="form-label">التكلفة التقديرية</label>
            <input type="number" class="form-control" id="estimate_cost" name="estimate_cost" min="0" step="0.01" required value="{{ $mubadara->estimate_cost }}">
        </div>
        
        <div class="mb-3">
            <label for="dangers" class="form-label">المخاطر</label>
            <textarea class="form-control" id="dangers" name="dangers" rows="4" required>{{ $mubadara->dangers }}</textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">تحديث</button>
        </div>
    </div>
    </form>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endsection