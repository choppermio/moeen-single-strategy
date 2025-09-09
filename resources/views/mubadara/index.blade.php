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
                <td>{{ $mubadara->name }}</td>                <td>
                    <div class="d-flex align-items-center">
                        <div class="progress progress-sm flex-grow-1 mr-2">
                            <div class="progress-bar 
                                {{ $mubadara->percentage >= 70 ? 'bg-success' : ($mubadara->percentage >= 40 ? 'bg-warning' : 'bg-danger') }}" 
                                role="progressbar" 
                                style="width: {{ $mubadara->percentage }}%;" 
                                aria-valuenow="{{ $mubadara->percentage }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                        <span class="text-nowrap font-weight-bold {{ $mubadara->percentage >= 70 ? 'text-success' : ($mubadara->percentage >= 40 ? 'text-warning' : 'text-danger') }}">
                            {{ $mubadara->percentage }}%
                        </span>
                    </div>
                </td>
                @php
                @endphp
                <td>{{ \App\Models\EmployeePosition::where('id',$mubadara->user_id)->first()->name }} </td>
                <td>
                    <!--<form action="{{ route('mubadara.destroy', $mubadara->id) }}" method="POST" style="display: inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="btn btn-danger">حذف</button>-->
                    <!--</form>-->
                                        @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))

                    <a href="{{ route('mubadara.edit', $mubadara->id) }}" class="btn btn-primary">تعديل</a>
               @endif
               
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection