@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <x-page-heading :title="'الإجراءات'"  />

    @php
        // Calculate average percentage
        $totalTasks = $tasks->count();
        $totalPercentage = $tasks->sum('percentage');
        $averagePercentage = $totalTasks > 0 ? round($totalPercentage / $totalTasks, 1) : 0;
        
        // Determine progress bar color based on percentage
        $progressBarColor = 'bg-danger'; // Red for low progress
        if ($averagePercentage >= 70) {
            $progressBarColor = 'bg-success'; // Green for high progress
        } elseif ($averagePercentage >= 40) {
            $progressBarColor = 'bg-warning'; // Yellow for medium progress
        }
        
        // Status text based on progress
        $statusText = 'بداية العمل';
        if ($averagePercentage >= 90) {
            $statusText = 'قارب على الانتهاء';
        } elseif ($averagePercentage >= 70) {
            $statusText = 'تقدم ممتاز';
        } elseif ($averagePercentage >= 50) {
            $statusText = 'تقدم جيد';
        } elseif ($averagePercentage >= 25) {
            $statusText = 'تقدم متوسط';
        }

        // Calculate task counts by status
        $completedTasks = $tasks->where('percentage', '>=', 100)->count();
        $inProgressTasks = $tasks->where('percentage', '>', 0)->where('percentage', '<', 100)->count();
        $notStartedTasks = $tasks->where('percentage', 0)->count();
    @endphp

    <!-- Progress Overview Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي التقدم في الإجراءات
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $averagePercentage }}%
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar {{ $progressBarColor }}" 
                                             role="progressbar" 
                                             style="width: {{ $averagePercentage }}%"
                                             aria-valuenow="{{ $averagePercentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-tasks"></i>
                                {{ $statusText }} • {{ $totalTasks }} إجراء
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="text-center">
                                <div class="progress-circle" data-percentage="{{ $averagePercentage }}">
                                    <svg width="60" height="60">
                                        <circle cx="30" cy="30" r="25" stroke="#e3e6f0" stroke-width="4" fill="none"/>
                                        <circle cx="30" cy="30" r="25" stroke="{{ $averagePercentage >= 70 ? '#1cc88a' : ($averagePercentage >= 40 ? '#f6c23e' : '#e74a3b') }}" 
                                                stroke-width="4" fill="none" 
                                                stroke-dasharray="{{ 2 * 3.14159 * 25 }}" 
                                                stroke-dashoffset="{{ 2 * 3.14159 * 25 * (1 - $averagePercentage / 100) }}"
                                                stroke-linecap="round"
                                                transform="rotate(-90 30 30)"/>
                                    </svg>
                                    <div class="percentage-text">{{ $averagePercentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                الإجراءات المكتملة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $completedTasks }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                قيد التنفيذ
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $inProgressTasks }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                لم تبدأ
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $notStartedTasks }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي الإجراءات
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalTasks }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>الإسم</th>
                <th>المخرج</th>
                <th>النسبة</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>         
                <td>{{ $task->output }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="progress progress-sm flex-grow-1 mr-2">
                            <div class="progress-bar 
                                {{ $task->percentage >= 70 ? 'bg-success' : ($task->percentage >= 40 ? 'bg-warning' : 'bg-danger') }}" 
                                role="progressbar" 
                                style="width: {{ $task->percentage }}%;" 
                                aria-valuenow="{{ $task->percentage }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                        <span class="text-nowrap font-weight-bold {{ $task->percentage >= 70 ? 'text-success' : ($task->percentage >= 40 ? 'text-warning' : 'text-danger') }}">
                            {{ $task->percentage }}%
                        </span>
                    </div>
                </td>
                <td>
                    <form action="{{ route('task.destroy', $task->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                    @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
                    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary">تعديل </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<style>
.progress-circle {
    position: relative;
    display: inline-block;
}

.progress-circle svg {
    transform: rotate(-90deg);
}

.percentage-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
    font-size: 12px;
    color: #333;
}

.progress-sm {
    height: 0.75rem;
    border-radius: 10px;
}

.progress-bar {
    transition: width 1.5s ease-in-out;
    border-radius: 10px;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.text-xs {
    font-size: 0.7rem;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

/* Animation for progress bars */
@keyframes progressAnimation {
    from {
        width: 0%;
    }
    to {
        width: var(--target-width);
    }
}

.progress-bar {
    animation: progressAnimation 2s ease-in-out;
}

/* Circular progress animation */
@keyframes circleProgress {
    from {
        stroke-dashoffset: 157.08; /* Full circle */
    }
    to {
        stroke-dashoffset: var(--target-offset);
    }
}

.progress-circle circle:last-child {
    animation: circleProgress 2s ease-in-out;
}
</style>

@endsection