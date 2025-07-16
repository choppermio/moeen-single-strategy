@extends('layouts.admin')

@section('content')
<div class="container">

    <x-page-heading :title="'تعديل هدف استراتيجي'" />

    <form method="POST" action="{{ route('hadafstrategies.update', $hadafstrategy->id) }}">
        @csrf
        @method('PUT') <!-- This line is crucial for Laravel to recognize it as an update request -->

        <div class="form-group">
            <label for="name">الإسم:</label>
            <input type="text" class="form-control" name="name" value="{{ $hadafstrategy->name }}"/>
            <br />
            <label for="name">المدير:</label>

            <select name="user_id" class="form-control">
                @foreach ($employee_positions as $employee_position)
                    <option value="{{ $employee_position->id }}" {{ $hadafstrategy->user_id == $employee_position->id ? 'selected' : '' }}>{{ $employee_position->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">تحديث</button>
        </div>
    </form>
</div>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection
