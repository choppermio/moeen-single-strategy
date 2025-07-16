@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);
// dd('a');
@endphp

@section('content')
<div class="container">
    <x-page-heading :title="'إنشاء مؤشر استراتيجي'"  />

<form method="post" action="{{ route('moasheradastrategy.store') }}">
    @csrf
<div class="form-group">
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name" required/>
</div>

<div class="form-group">
    <label for="name">الهدف الإستراتيجي</label>
    <select name="hadafstrategy" class="form-control d-none" >
        @foreach ($hadafstrategies as $hadafstrategy)
        <option value="{{ $hadafstrategy->id }}" @if( $hadafstrategy->id == $_GET['selected']) @php $selected = $hadafstrategy->name ; @endphp selected @endif>{{ $hadafstrategy->name }}</option>
        
        @endforeach
    </select>
    {{ $selected ?? '' }}
    </div>


<div class="form-group">
    <button class="btn btn-primary" type="submit">إنشاء</button>
</form>
</div>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection