@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<style>
    /* Hide everything in the page when printing */
@media print {
    ul#accordionSidebar,.addnewButton,#dataTable3_filter,.dataTables_info{
        display: none;
    }

    #dataTable3{
        height: 100%;
    }
    /* Only display #dataTable3 and its necessary elements */
    /* #dataTable3, #dataTable3 * {
        visibility: visible;
    } */

    /* Position the #dataTable3 at the start of the page */
    
}
table#dataTable3 tr{height:50px !important;}
</style>
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <x-page-heading :title="'الأهداف الإستراتيجية'"  />

    <a class="d-none" href="{{url('/hadafstrategies/create')}}"><button class="addnewButton">أضف جديد</button></a>

    <table class="table table-striped" id="dataTable3" width="100%" cellspacing="0" style="text-align: center">
        <thead  style="text-align: center">
            <tr>
                <th  style="text-align: center">إسم الهدف</th>
                <th  style="text-align: center">النسبة</th>
                <th  style="text-align: center">مدير الهدف الإستراتيجي</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hadafstrategies as $strategy)
            <tr>
                <td>{{ $strategy->name }}</td>
                <td>{{ $strategy->percentage }} %</td>
                @php
                @endphp
                <td>
                    @php
                    @endphp
                   {{ \App\Models\EmployeePosition::where('id',$strategy->user_id)->first()->name }}
                    </td>
                {{-- <td>
                    <!--<form action="{{ route('hadafstrategies.destroy', $strategy->id) }}" method="POST" style="display: inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="btn btn-danger">حذف</button>-->
                    <!--</form>-->
                    <a href="{{ route('hadafstrategies.edit', $strategy->id) }}" class="btn btn-primary">تعديل</a>
                    <a href="newstrategy?id={{ $strategy->id }}" class="btn btn-primary">عرض</a>

                </td> --}}
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable3').DataTable({
            dom: 'Bfrtip',  // Ensures the button container is included in the layout
            buttons: [
                'print'  // Defines the print button
            ],
            paging: false,
            //order asc
            "order": [[ 1, "desc" ]],
            // Turns off pagination
        });
    });
    </script>
    
    
@endsection