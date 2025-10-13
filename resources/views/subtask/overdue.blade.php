@extends('layouts.admin')


@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<div class="container-fluid mt-4">
    <x-page-heading :title="'مهام متأخرة'" />

    <div class="card">
        <div class="card-body">
            @php
                // Prepare filter lists from the current subtasks collection
                $statusOptions = $subtasks->pluck('status')->unique()->filter()->values();
                $responsibleIds = $subtasks->pluck('user_id')->unique()->filter()->values();
                $responsibles = \App\Models\EmployeePosition::whereIn('id', $responsibleIds)->get()->keyBy('id');
            @endphp

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>الحالة</label>
                    <select id="filter-status" class="form-control form-control-sm">
                        <option value="">كل الحالات</option>
                        @foreach($statusOptions as $st)
                            <option value="{{ $st }}">{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>المسؤول</label>
                    <select id="filter-responsible" class="form-control form-control-sm">
                        <option value="">الكل</option>
                        @foreach($responsibles as $r)
                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button id="clear-filters" class="btn btn-sm btn-secondary">مسح الفلاتر</button>
                </div>
            </div>
            <table class="table table-striped table-sm" id="overdueTable" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المهمة الفرعية</th>
                        <th>المهمة الرئيسية</th>
                        <th>مسؤول المهمة</th>
                        <th>تاريخ الاستحقاق</th>
                        <th>نسبة الإكمال</th>
                        <th>الحالة</th>
                        <th>شواهد</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subtasks as $subtask)
                        @php
                            $task = \App\Models\Task::find($subtask->parent_id);
                            $mubadara = $task ? \App\Models\Mubadara::find($task->parent_id) : null;
                            $responsible = \App\Models\EmployeePosition::where('id', $subtask->user_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $subtask->id }}</td>
                            <td>{{ $subtask->name }}</td>
                            <td>{{ $task->name ?? 'غير محدد' }}</td>
                            <td>{{ $responsible->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($subtask->due_time)->format('d-m-Y H:i') }}</td>
                            <td>{{ $subtask->percentage }} %</td>
                            <td>
                                @php
                                    // Map ticket-like status display from ticketshow blade
                                    $status = $subtask->status ?? 'pending';
                                @endphp

                                {{-- raw status for searching by DataTables (hidden) --}}
                                <span class="d-none raw-status">{{ $status }}</span>
                                @switch($status)
                                    @case('pending')
                                    @case('pending-approval')
                                    @case('strategy-pending-approval')
                                        <span class="badge badge-warning">بانتظار الموافقة</span>
                                        @break

                                    @case('rejected')
                                        <span class="badge badge-danger">تم الرفض</span>
                                        @break

                                    @case('approved')
                                        <span class="badge badge-success">تمت الموافقة</span>
                                        @break

                                    @case('transfered')
                                        <span class="badge badge-warning">تمت عملية الإسناد</span>
                                        @break

                                    @default
                                        <span class="badge badge-secondary">حالة غير معروفة</span>
                                @endswitch
                            </td>
                            <td>
                                @if($subtask->ticket_id)
                                    <a href="{{ url(env('APP_URL_REAL') . '/mysubtasks-evidence/' . $subtask->id) }}" target="_blank" class="btn btn-sm btn-info">الشواهد</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('subtask.show', $subtask->id) }}" class="btn btn-sm btn-primary">عرض</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<!-- Initialize DataTable after layout loads jQuery and DataTables scripts -->
<script>
    $(document).ready(function(){
        var table = $('#overdueTable').DataTable({
            order: [[4, 'asc']],
            pageLength: 25
        });

        // column indexes: 0:id,1:name,2:task,3:responsible,4:due_time,5:percentage,6:status
        $('#filter-status').on('change', function() {
            var val = $(this).val();
            table.column(6).search(val).draw();
        });

        $('#filter-responsible').on('change', function() {
            var val = $(this).val();
            table.column(3).search(val).draw();
        });

        $('#clear-filters').on('click', function() {
            $('#filter-status').val('');
            $('#filter-responsible').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endpush

@endsection
