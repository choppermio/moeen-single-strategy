@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <x-page-heading :title="'المبادرات'"  />

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>الإسم</th>
                <th>النسبة</th>
                <th>المدير</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mubadaras as $mubadara)
            <tr>
                <td>{{ $mubadara->name }}</td>
                <td>{{ $mubadara->percentage }} %</td>
                @php
                @endphp
                <td>{{ \App\Models\EmployeePosition::where('id',$mubadara->user_id)->first()->name }} </td>
                <td>
                    <form action="{{ route('hadafstrategies.destroy', $mubadara->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                    <a href="{{ route('hadafstrategies.edit', $mubadara->id) }}" class="btn btn-primary">تعديل</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection