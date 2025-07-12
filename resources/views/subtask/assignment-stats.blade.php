@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <x-page-heading :title="'إحصائيات إسناد المهام'" />

    <div class="row">
        <!-- Total Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي المهام</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Subtasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                إجمالي المهام الفرعية</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_subtasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multi-assigned Tasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                مهام مسندة لأكثر من شخص</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['multi_assigned_tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multi-assigned Subtasks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                مهام فرعية مسندة لأكثر من شخص</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['multi_assigned_subtasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Unassigned Tasks Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                مهام غير مسندة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unassigned_tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unassigned Subtasks Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                مهام فرعية غير مسندة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unassigned_subtasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات إضافية</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>ملاحظة:</strong> هذه الصفحة تعرض إحصائيات حول إسناد المهام في النظام.</p>
                    <ul>
                        <li><strong>المهام المسندة لأكثر من شخص:</strong> يمكن الآن إسناد المهمة الواحدة لعدة أشخاص للعمل عليها بشكل تعاوني.</li>
                        <li><strong>المهام غير المسندة:</strong> هذه المهام تحتاج إلى إسناد لموظفين للعمل عليها.</li>
                        <li><strong>لإسناد المهام:</strong> توجه إلى صفحة <a href="{{ route('subtask.settomyteam') }}" class="text-primary">إسناد لفريقي</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
