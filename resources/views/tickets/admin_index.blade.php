@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @php
        $strategyControlIds = explode(',', env('STRATEGY_CONTROL_ID'));
        $strategyControlIds = array_map('trim', $strategyControlIds);
    @endphp
    @if(in_array((string)current_user_position()->id, $strategyControlIds))
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إدارة جميع التذاكر</h1>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">جميع التذاكر في النظام</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>رقم التذكرة</th>
                            <th>اسم التذكرة</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>لديها مهمة فرعية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->name }}</td>
                            <td>
                                @if($ticket->fromEmployeePosition && $ticket->fromEmployeePosition->user)
                                    {{ $ticket->fromEmployeePosition->user->name }}
                                    <br><small class="text-muted">{{ $ticket->fromEmployeePosition->name }}</small>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->employeePosition && $ticket->employeePosition->user)
                                    {{ $ticket->employeePosition->user->name }}
                                    <br><small class="text-muted">{{ $ticket->employeePosition->name }}</small>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                            <td>
                                @switch($ticket->status)
                                    @case('pending')
                                        <span class="badge badge-warning">معلقة</span>
                                        @break
                                    @case('approved')
                                        <span class="badge badge-success">معتمدة</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge badge-danger">مرفوضة</span>
                                        @break
                                    @case('completed')
                                        <span class="badge badge-primary">مكتملة</span>
                                        @break
                                    @case('transfered')
                                        <span class="badge badge-info">محولة</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ $ticket->status }}</span>
                                @endswitch
                            </td>
                            <td>{{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : 'غير محدد' }}</td>
                            <td>{{ $ticket->due_time ? \Carbon\Carbon::parse($ticket->due_time)->format('Y-m-d H:i') : 'غير محدد' }}</td>
                            <td>
                                @if($ticket->subtasks->count() > 0)
                                    <span class="badge badge-success">نعم ({{ $ticket->subtasks->count() }})</span>
                                @else
                                    <span class="badge badge-secondary">لا</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tickets.admin.edit', $ticket->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('tickets.admin.destroy', $ticket->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذه التذكرة؟ سيتم حذف جميع المهام الفرعية المرتبطة بها أيضاً.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include DataTables -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json"
        },
        "pageLength": 25,
        "order": [[ 0, "desc" ]]
    });
});
</script>
@endsection
