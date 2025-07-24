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

<div class="tree-node">
    <div class="tree-node-content">
        <div class="{{ $cardClass }}" data-employee-id="{{ $employee['id'] }}">
            <div class="level-badge">
                @if($employee['level'] == 1)
                    المدير التنفيذي
                @else
                    المستوى {{ $employee['level'] }}
                @endif
            </div>
            
            <div class="card-header">
                <div class="employee-name">
                    {{ $employee['user_name'] ?? $employee['name'] }}
                </div>
                <div class="employee-position">
                    {{ $employee['name'] }}
                </div>
                
                @if($employee['user_email'])
                <div style="font-size: 0.85rem; color: #7f8c8d; margin-top: 8px;">
                    <i class="fas fa-envelope"></i> {{ $employee['user_email'] }}
                </div>
                @endif
            </div>
            
            <div class="card-body">
                <div class="employee-stats">
                    <div class="stat-item">
                        <span class="stat-value text-primary">{{ $employee['total_subordinates'] }}</span>
                        <div class="stat-label">المرؤوسين</div>
                    </div>
                    
                    <div class="stat-item">
                        <span class="stat-value text-{{ $performanceColor }}">{{ number_format($employee['avg_performance'], 1) }}%</span>
                        <div class="stat-label">الأداء</div>
                    </div>
                    
                    <div class="stat-item">
                        <span class="stat-value text-info">{{ $employee['total_tasks'] }}</span>
                        <div class="stat-label">المهام</div>
                    </div>
                    
                    <div class="stat-item">
                        <span class="stat-value text-success">{{ number_format($employee['completion_rate'], 1) }}%</span>
                        <div class="stat-label">الإنجاز</div>
                    </div>
                </div>
                
                <!-- Performance Bar -->
                <div class="performance-bar">
                    <div class="performance-fill" style="width: {{ number_format($employee['avg_performance'], 0) }}%"></div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ url('/mysubtasks?show-as-admin=t&id='.$employee['id']) }}" 
                       class="btn-tree btn-tree-primary">
                        <i class="fas fa-tasks"></i> المهام
                    </a>
                    
                    @if($employee['total_tasks'] > 0)
                    <a href="{{ url('/subtask-analyst?type=month&id='.date('m').'&department_id='.$employee['id']) }}" 
                       class="btn-tree btn-tree-info">
                        <i class="fas fa-chart-bar"></i> التقرير
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if(count($employee['children']) > 0)
        <div class="tree-children">
            @foreach($employee['children'] as $child)
                @include('stats.partials.tree-node', ['employee' => $child, 'isRoot' => false])
            @endforeach
        </div>
    @endif
</div>
