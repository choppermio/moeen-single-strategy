@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);
@endphp

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">

<div class="container mt-5">

@if (!empty($current_employee_score))
<h4 style="color: black; background:white; border:3px dashed orange; text-align:center;">
    <p>المنصب الوظيفي للموظف: {{ $current_employee_score[0]['employee_position']->name }}</p>
    <p>النسبة: {{ floor($current_employee_score[0]['percentage']) }}</p>
</h4>
@endif
    <h2 class="text-center mb-4">
        جدول أفضل 5 موظفين بناءً على نسبة المهام المكتملة في الربع 
        {{ \Carbon\Carbon::now()->quarter }} 
        لسنة 
        {{ \Carbon\Carbon::now()->year }}
    </h2>
    
    <div class="table-responsive">
    <table class="table table-bordered table-striped" id="employeesTable">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">اسم الموظف</th>
                <th scope="col">الوظيفة</th>
                <th scope="col">النسبة المئوية</th>
                <th scope="col">إجمالي المهام</th>
                <th scope="col">إجمالي المهام المكتملة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($top_5_employees as $index => $employee)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $employee['employee_position']->user->name }}</td>
                    <td>{{ $employee['employee_position']->name }}</td>
                    <td>
                        @if ($employee['total_subtasks'] > 0)
                            {{ number_format(($employee['total_completed_subtasks'] / $employee['total_subtasks']) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <!-- <td>{{ number_format($employee['percentage'], 2) }}%</td> -->
                    <td>{{ $employee['total_subtasks'] }}</td>
                    <td>{{ $employee['total_completed_subtasks'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <a href="{{ route('subtask.mysubtasks') }}"><button class="btn btn-info" style="text-align: center; width:100%">الذهاب الى مهامي</button></a>
</div>

@endsection

<!-- DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#employeesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
        },
        "pageLength": 1000,
        "order": [[3, "desc"]], // Sort by percentage column (index 3) in descending order
        "columnDefs": [
            { 
                "targets": [3], // Percentage column
                "type": "num-fmt", // Treat as numeric for proper sorting
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return data;
                    }
                    // For sorting, extract numeric value from percentage string
                    return parseFloat(data.replace('%', ''));
                }
            },
            { 
                "targets": [4, 5], // Total tasks and completed tasks columns
                "type": "num" // Treat as numeric
            }
        ],
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'copy',
                text: 'نسخ',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':visible'
                },
                title: 'أفضل الموظفين - الربع {{ \Carbon\Carbon::now()->quarter }} لسنة {{ \Carbon\Carbon::now()->year }}'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    columns: ':visible'
                },
                title: 'أفضل الموظفين - الربع {{ \Carbon\Carbon::now()->quarter }} لسنة {{ \Carbon\Carbon::now()->year }}',
                customize: function(doc) {
                    doc.defaultStyle.font = 'Arial';
                    doc.styles.tableHeader.alignment = 'center';
                }
            },
            {
                extend: 'print',
                text: 'طباعة',
                exportOptions: {
                    columns: ':visible'
                },
                title: 'أفضل الموظفين - الربع {{ \Carbon\Carbon::now()->quarter }} لسنة {{ \Carbon\Carbon::now()->year }}'
            }
        ],
        "responsive": true,
        "searching": true,
        "info": true,
        "lengthChange": true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "الكل"]],
        "pagingType": "full_numbers"
    });
});
</script>

