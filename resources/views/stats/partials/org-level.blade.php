@php
    // Group children by level for proper alignment
    $allChildren = [];
    foreach($employees as $employee) {
        if(count($employee['children']) > 0) {
            $allChildren = array_merge($allChildren, $employee['children']);
        }
    }
@endphp

<div class="org-level level-{{ $level }}">
    @foreach($employees as $employee)
        <div class="tree-node">
            @include('stats.partials.employee-card-simple', ['employee' => $employee])
        </div>
    @endforeach
</div>

@if(count($allChildren) > 0)
    @include('stats.partials.org-level', ['employees' => $allChildren, 'level' => $level + 1])
@endif
