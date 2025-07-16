@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <x-page-heading :title="'المهام'"  />

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>الإسم</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subtasks as $subtask)
            <tr>
                <td>{{ $subtask->name }}</td>
                <td>
                    <!--<form action="{{ route('hadafstrategies.destroy', $subtask->id) }}" method="POST" style="display: inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="btn btn-danger">حذف</button>-->
                    <!--</form>-->
                                        @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
                                        <a href="{{ route('subtask.edit', $subtask->id) }}" class="btn btn-primary">تعديل</a>
                                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection