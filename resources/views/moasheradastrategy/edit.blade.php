@extends('layouts.admin')

@section('content')
<div class="container">
    <x-page-heading :title="'تعديل مؤشر استراتيجي'" />

    <!-- Adjust the form action to point to the update route -->
    <!-- Assuming 'moasheradastrategy' is the route name for the update and you have the strategic indicator's id -->
    <form method="post" action="{{ route('moasheradastrategy.update', $moasheradastrategy->id) }}">
        @csrf
        @method('PUT') <!-- This is necessary for Laravel to treat this as a PUT request -->

        <div class="form-group">
            <label for="name">الإسم:</label>
            <!-- Pre-fill the name input -->
            <input type="text" class="form-control" name="name" value="{{ $moasheradastrategy->name }}"/>
        </div>

        <div class="form-group">
            <label for="name">الهدف الإستراتيجي:</label>
            <select name="hadafstrategy" class="form-control">
                @foreach ($hadafstrategies as $hadafstrategy)
                    <option value="{{ $hadafstrategy->id }}" {{ $hadafstrategy->id == $moasheradastrategy->parent_id ? 'selected' : '' }}>{{ $hadafstrategy->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">تحديث</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection
