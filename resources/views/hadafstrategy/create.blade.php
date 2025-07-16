@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<div class="container">

    <x-page-heading :title="'إنشاء هدف استراتيجي'"  />

<form method="post" action="{{ route('hadafstrategies.store') }}">
    @csrf
<div class="form-group">
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name" required/>
<br />
<label for="name">المدير:</label>

<select name="user_id" class="form-control">
    @foreach ($employee_positions as $employee_position)
    @if(current_user_position()->id !=$employee_position->id)
        <option value="{{ $employee_position->id }}">{{ $employee_position->name }}</option>
        @endif
        @endforeach
</select>

</div>
<div class="form-group">
    <button class="btn btn-primary">إرسال</button>
</form>
</div>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection