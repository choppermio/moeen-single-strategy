@php
    $cardClass = 'employee-card level-' . $employee['level'];
    $performanceColor = 'success';
    if ($employee['avg_performance'] < 30) {
        $performanceColor = 'danger';
    } elseif ($employee['avg_performance'] < 60) {
        $performanceColor = 'warning';
    } elseif ($employee['avg_performance'] < 80) {
        $performanceColor = 'info';
    }
@endphp

<div class="{{ $cardClass }}" data-employee-id="{{ $employee['id'] }}">
    <div class="level-badge">المستوى {{ $employee['level'] }}</div>
    
    <div class="card-header">
        <div class="employee-name">
            {{ $employee['user_name'] ?? $employee['name'] }}
        </div>
        <div class="employee-position">
            {{ $employee['name'] }}
        </div>
        
        @if($employee['user_email'])
        <div style="font-size: 0.8rem; color: #7f8c8d;">
            <i class="fas fa-envelope"></i> {{ $employee['user_email'] }}
        </div>
        @endif
    </div>
    
    <div class="card-body">
        <div class="employee-stats">
            <div class="stat-item">
                <div class="stat-value text-primary">{{ $employee['total_subordinates'] }}</div>
                <div class="stat-label">المرؤوسين</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-value text-{{ $performanceColor }}">{{ $employee['avg_performance'] }}%</div>
                <div class="stat-label">الأداء</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-value text-info">{{ $employee['total_tasks'] }}</div>
                <div class="stat-label">المهام</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-value text-success">{{ $employee['completion_rate'] }}%</div>
                <div class="stat-label">الإنجاز</div>
            </div>
        </div>
        
        <!-- Performance Bar -->
        <div class="performance-bar">
            <div class="performance-fill" style="width: {{ number_format($employee['avg_performance'], 0) }}%"></div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-3 text-center">
            <a href="{{ url('/mysubtasks?show-as-admin=t&id='.$employee['id']) }}" 
               class="btn btn-sm btn-outline-primary">
                <i class="fas fa-tasks"></i> المهام
            </a>
            
            @if($employee['total_tasks'] > 0)
            <a href="{{ url('/subtask-analyst?type=month&id='.date('m').'&department_id='.$employee['id']) }}" 
               class="btn btn-sm btn-outline-info">
                <i class="fas fa-chart-bar"></i> التقرير
            </a>
            @endif
        </div>
    </div>
</div>

@if(count($employee['children']) > 0)
    <div class="tree-children">
        @foreach($employee['children'] as $child)
            <div class="tree-node">
                @include('stats.partials.employee-card-tree', ['employee' => $child, 'level' => $level + 1])
            </div>
        @endforeach
    </div>
@endif
