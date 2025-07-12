@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تغيير كلمة المرور</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('password.update2') }}">
        @csrf

        <div class="form-group">
            <label for="current_password">كلمة المرور الحالية</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
            @error('current_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password">كلمة المرور الجديدة</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
            @error('new_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">تأكيد كلمة المرور الجديدة</label>
            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required>
            @error('new_password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
    </form>
</div>
@endsection
