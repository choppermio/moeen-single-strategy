@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">لوحة الإحصائيات</h1>
    </div>

    <!-- Date Range Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">تصفية حسب تاريخ</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('stats.dashboard') }}" class="row align-items-end">
                <div class="col-md-4">
                    <label for="from_date" class="form-label">من تاريخ:</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" 
                           value="{{ $fromDate ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="to_date" class="form-label">إلى تاريخ:</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" 
                           value="{{ $toDate ?? '' }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> تطبيق التصفية
                    </button>
                    <a href="{{ route('stats.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> إزالة التصفية
                    </a>
                </div>
            </form>
            @if($fromDate || $toDate)
            <div class="mt-3">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    يتم عرض الإحصائيات للفترة من 
                    <strong>{{ $fromDate ? \Carbon\Carbon::parse($fromDate)->format('Y/m/d') : 'البداية' }}</strong>
                    إلى 
                    <strong>{{ $toDate ? \Carbon\Carbon::parse($toDate)->format('Y/m/d') : 'النهاية' }}</strong>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Content Row - Summary Cards -->
    <div class="row">
        
        <!-- Strategic Goals Average Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                متوسط الأهداف الاستراتيجية</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($strategicGoalsAverage, 1) }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullseye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                عدد المهام المنجزة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($completedTasks) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">عدد المهام قيد العمل</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($inProgressTasks) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                عدد المهام المتأخرة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <a href="{{ route('subtask.overdue.public') }}" class="text-warning" style="text-decoration: underline;">
                                    {{ number_format($overdueTasks) }}
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row - Performance Tables -->
    <div class="row">

        <!-- Department Performance -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> متوسط أداء كل إدارة او قسم</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="departmentTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>اسم الإدارة/القسم</th>
                                    <th>متوسط الأداء</th>
                                    <th>عدد الموظفين</th>
                                    <th>المهام المكتملة</th>
                                    <th>إجمالي المهام</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentPerformance as $dept)
                                <tr>
                                    <td>{{ $dept['name'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2">{{ $dept['average_percentage'] }}%</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar 
                                                    @if($dept['average_percentage'] >= 80) bg-success
                                                    @elseif($dept['average_percentage'] >= 60) bg-warning
                                                    @else bg-danger
                                                    @endif"
                                                     role="progressbar" style="width: {{ $dept['average_percentage'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $dept['employees_count'] }}</td>
                                    <td>{{ $dept['completed_tasks'] }}</td>
                                    <td>{{ $dept['total_tasks'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Employee Performance -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">أفضل أداء للموظفين</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="employeeTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>اسم الموظف</th>
                                    <th>متوسط الأداء</th>
                                    <th>المهام المكتملة</th>
                                    <th>إجمالي المهام</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeePerformance->take(100) as $emp)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $emp['name'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $emp['user_name'] }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2">{{ $emp['average_percentage'] }}%</span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar 
                                                    @if($emp['average_percentage'] >= 80) bg-success
                                                    @elseif($emp['average_percentage'] >= 60) bg-warning
                                                    @else bg-danger
                                                    @endif"
                                                     role="progressbar" style="width: {{ $emp['average_percentage'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $emp['completed_tasks'] }}</td>
                                    <td>{{ $emp['total_tasks'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($employeePerformance->count() > 10)
                    <div class="text-center mt-3">
                        <button class="btn btn-primary" onclick="showAllEmployees()">عرض جميع الموظفين</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row - Additional Statistics -->
    <div class="row">
        
        <!-- Overall Completion Rate -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معدل الإنجاز العام</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">معدل إنجاز المهام العام
                        <span class="float-right">{{ number_format($completionRate, 1) }}%</span>
                    </h4>
                    <div class="progress mb-4">
                        <div class="progress-bar 
                            @if($completionRate >= 80) bg-success
                            @elseif($completionRate >= 60) bg-warning  
                            @else bg-danger
                            @endif" 
                             role="progressbar" style="width: {{ $completionRate }}%"
                             aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="card border-left-success shadow py-2">
                                <div class="card-body">
                                    <div class="text-success">مكتملة</div>
                                    <div class="h4 mb-0 font-weight-bold">{{ $completedTasks }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-info shadow py-2">
                                <div class="card-body">
                                    <div class="text-info">قيد العمل</div>
                                    <div class="h4 mb-0 font-weight-bold">{{ $inProgressTasks }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-warning shadow py-2">
                                <div class="card-body">
                                    <div class="text-warning">متأخرة</div>
                                    <div class="h4 mb-0 font-weight-bold">{{ $overdueTasks }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow py-2">
                                <div class="card-body">
                                    <div class="text-primary">الإجمالي</div>
                                    <div class="h4 mb-0 font-weight-bold">{{ $totalTasks }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- All Employees Modal -->
<div class="modal fade" id="allEmployeesModal" tabindex="-1" role="dialog" aria-labelledby="allEmployeesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allEmployeesModalLabel">جميع الموظفين - تفصيل الأداء</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="allEmployeesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>اسم الموظف</th>
                                <th>اسم المستخدم</th>
                                <th>متوسط الأداء</th>
                                <th>معدل الإنجاز</th>
                                <th>المهام المكتملة</th>
                                <th>إجمالي المهام</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employeePerformance as $emp)
                            <tr>
                                <td>{{ $emp['name'] }}</td>
                                <td>{{ $emp['user_name'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{ $emp['average_percentage'] }}%</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar 
                                                @if($emp['average_percentage'] >= 80) bg-success
                                                @elseif($emp['average_percentage'] >= 60) bg-warning
                                                @else bg-danger
                                                @endif"
                                                 role="progressbar" style="width: {{ $emp['average_percentage'] }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $emp['completion_rate'] }}%</td>
                                <td>{{ $emp['completed_tasks'] }}</td>
                                <td>{{ $emp['total_tasks'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<script>
function showAllEmployees() {
    $('#allEmployeesModal').modal('show');
    $('#allEmployeesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json"
        },
        "order": [[ 2, "desc" ]], // Sort by performance percentage
        "pageLength": 25
    });
}

$(document).ready(function() {
    $('#departmentTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json"
        },
        "order": [[ 1, "desc" ]], // Sort by performance percentage
        "pageLength": 10
    });
    
    $('#employeeTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json"
        },
        "order": [[ 1, "desc" ]], // Sort by performance percentage
        "pageLength": 10,
        "searching": false,
        "paging": false,
        "info": false
    });
});
</script>

@endsection
