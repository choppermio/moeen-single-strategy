
@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <x-page-heading :title="'مؤشرات الكفاءة والفعالية'"  />

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>الإسم</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($moashermkmfs as $moashermkmf)
            <tr>
                <td>{{ $moashermkmf->name }}</td>
                <td>
                    <!--<form action="{{ route('moashermkmf.destroy', $moashermkmf->id) }}" method="POST" style="display: inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="btn btn-danger">الحذف</button>-->
                    <!--</form>-->
                                        @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
                                        <a href="{{ route('moashermkmf.edit', $moashermkmf->id) }}" class="btn btn-primary">التعديل</a>
                                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection