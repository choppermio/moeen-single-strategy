@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">الهيكل التنظيمي</h1>
        <a href="{{ route('stats.dashboard') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-chart-area fa-sm text-white-50"></i> العودة للإحصائيات
        </a>
    </div>

    <!-- Organizational Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">خريطة التنظيم الإداري</h6>
                </div>
                <div class="card-body" style="background-color: #f8f9fc;">
                    <div class="org-chart-container">
                        <div class="org-chart">
                            @include('stats.partials.org-level', ['employees' => $hierarchy, 'level' => 1])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي الموظفين
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalEmployees = \App\Models\EmployeePosition::count();
                                @endphp
                                {{ $totalEmployees }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                الإدارات الرئيسية
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ count($hierarchy) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sitemap fa-2x text-gray-300"></i>
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
                                متوسط الأداء العام
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    @php
                                        $overallPerformance = \App\Models\Subtask::avg('percentage') ?? 0;
                                    @endphp
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ round($overallPerformance, 1) }}%
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{ number_format($overallPerformance, 0) }}%"
                                             aria-valuenow="{{ $overallPerformance }}" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                إجمالي المهام
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalTasks = \App\Models\Subtask::count();
                                @endphp
                                {{ $totalTasks }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Organizational Chart Styles */
.org-chart-container {
    padding: 30px;
    overflow-x: auto;
    overflow-y: visible;
    min-height: 600px;
    background: radial-gradient(circle at 50% 50%, #f8f9fc 0%, #e9ecef 100%);
}

.org-chart {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.org-level {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 60px;
    margin: 50px 0;
    width: 100%;
    position: relative;
}

.org-level.level-1 {
    margin-top: 0;
}

.tree-node {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0;
}

.tree-node-content {
    position: relative;
    z-index: 2;
}

.employee-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.4s ease;
    border: 2px solid transparent;
    position: relative;
    width: 200px;
    margin: 0 auto;
    overflow: hidden;
}

.employee-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #e74a3b, #f39c12, #3498db, #2ecc71);
    z-index: 1;
}

.employee-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
}

.employee-card.level-1 {
    border-color: #e74a3b;
    background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%);
    width: 240px;
    transform: scale(1.05);
}

.employee-card.level-1:hover {
    transform: translateY(-6px) scale(1.08);
}

.employee-card.level-2 {
    border-color: #f39c12;
    background: linear-gradient(135deg, #ffffff 0%, #fffbf0 100%);
    width: 220px;
}

.employee-card.level-3 {
    border-color: #3498db;
    background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
    width: 200px;
}

.employee-card.level-4 {
    border-color: #2ecc71;
    background: linear-gradient(135deg, #ffffff 0%, #f0fff4 100%);
    width: 180px;
}

.employee-card.level-5 {
    border-color: #9b59b6;
    background: linear-gradient(135deg, #ffffff 0%, #f8f0ff 100%);
    width: 160px;
}

.card-header {
    border-bottom: none;
    padding: 15px 10px 10px 10px;
    text-align: center;
}

.card-body {
    padding: 10px 15px 15px 15px;
}

.employee-name {
    font-size: 1rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 5px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    line-height: 1.2;
}

.employee-position {
    font-size: 0.8rem;
    color: #7f8c8d;
    margin-bottom: 10px;
    font-weight: 500;
    line-height: 1.2;
}

.employee-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-bottom: 12px;
}

.stat-item {
    text-align: center;
    padding: 6px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-value {
    font-size: 1rem;
    font-weight: bold;
    color: #2c3e50;
    display: block;
}

.stat-label {
    font-size: 0.65rem;
    color: #95a5a6;
    text-transform: uppercase;
    margin-top: 2px;
    font-weight: 600;
}

.performance-bar {
    height: 6px;
    background: #ecf0f1;
    border-radius: 3px;
    margin: 10px 0;
    overflow: hidden;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
}

.performance-fill {
    height: 100%;
    background: linear-gradient(90deg, #e74c3c, #f39c12, #f1c40f, #2ecc71);
    transition: width 0.6s ease;
    border-radius: 4px;
    position: relative;
}

.performance-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.level-badge {
    position: absolute;
    top: -8px;
    right: 15px;
    background: #3498db;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 3;
}

.level-1 .level-badge { 
    background: linear-gradient(45deg, #e74a3b, #c0392b); 
    animation: pulse 2s infinite;
}
.level-2 .level-badge { background: linear-gradient(45deg, #f39c12, #d68910); }
.level-3 .level-badge { background: linear-gradient(45deg, #3498db, #2980b9); }
.level-4 .level-badge { background: linear-gradient(45deg, #2ecc71, #27ae60); }
.level-5 .level-badge { background: linear-gradient(45deg, #9b59b6, #8e44ad); }

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Tree Connection Lines */
.org-level:not(.level-1)::before {
    content: '';
    position: absolute;
    top: -40px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 40px;
    background: linear-gradient(180deg, #3498db, #2ecc71);
    border-radius: 2px;
    z-index: 1;
}

.org-level:not(.level-1)::after {
    content: '';
    position: absolute;
    top: -40px;
    left: 10%;
    right: 10%;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    border-radius: 2px;
    z-index: 1;
}

.tree-node:not(:only-child)::before {
    content: '';
    position: absolute;
    top: -40px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 40px;
    background: linear-gradient(180deg, #3498db, #2ecc71);
    border-radius: 2px;
    z-index: 1;
}

/* Hide connection lines for top level */
.org-level.level-1 .tree-node::before {
    display: none;
}

.tree-children {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    margin-top: 60px;
    gap: 40px;
    flex-wrap: wrap;
}

.tree-children::before {
    content: '';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    width: 3px;
    height: 30px;
    background: linear-gradient(180deg, #3498db, #2ecc71);
    border-radius: 2px;
}

.tree-children::after {
    content: '';
    position: absolute;
    top: -30px;
    left: 20%;
    right: 20%;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    border-radius: 2px;
}

.tree-node .tree-children .tree-node::before {
    content: '';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    width: 3px;
    height: 30px;
    background: linear-gradient(180deg, #3498db, #2ecc71);
    border-radius: 2px;
    z-index: 1;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
    margin-top: 10px;
}

.btn-tree {
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.btn-tree:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    text-decoration: none;
}

.btn-tree-primary {
    background: linear-gradient(45deg, #3498db, #2980b9);
    color: white;
}

.btn-tree-info {
    background: linear-gradient(45deg, #17a2b8, #138496);
    color: white;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .org-level {
        gap: 40px;
    }
    
    .employee-card {
        width: 180px !important;
    }
    
    .employee-card.level-1 {
        width: 200px !important;
    }
}

@media (max-width: 768px) {
    .org-chart-container {
        padding: 20px 10px;
    }
    
    .org-level {
        flex-direction: column;
        align-items: center;
        gap: 30px;
        margin: 40px 0;
    }
    
    .employee-card {
        width: 220px !important;
        transform: none !important;
    }
    
    .employee-card:hover {
        transform: translateY(-4px) scale(1.02) !important;
    }
    
    .employee-card.level-1 {
        width: 240px !important;
        transform: none !important;
    }
    
    .employee-stats {
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }
    
    .org-level:not(.level-1)::after {
        display: none;
    }
    
    .tree-node::before {
        display: none;
    }
}

@media (max-width: 480px) {
    .employee-card {
        width: 95% !important;
        max-width: 200px !important;
    }
    
    .employee-stats {
        grid-template-columns: 1fr;
        gap: 5px;
    }
    
    .org-level {
        gap: 20px;
        margin: 30px 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event to show employee details
    document.querySelectorAll('.employee-card').forEach(card => {
        card.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            if (employeeId) {
                // You can add modal or redirect to employee details
                console.log('Employee ID:', employeeId);
            }
        });
    });
});
</script>
@endsection
