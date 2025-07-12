@php
$assignments = [];
if ($type === 'task') {
    $assignments = \App\Models\TaskUserAssignment::getAssignedUsersForTask($id);
} else {
    $assignments = \App\Models\TaskUserAssignment::getAssignedUsersForSubtask($id);
}
@endphp

@if($assignments->count() > 0)
    <div class="assigned-users mb-2">
        <small class="text-info">
            <i class="fas fa-users"></i> المسند إلى: 
            @foreach($assignments as $assignment)
                @if($assignment->employeePosition && $assignment->employeePosition->user)
                    <span class="badge badge-info mr-1">
                        {{$assignment->employeePosition->name}} - {{$assignment->employeePosition->user->name}}
                    </span>
                @endif
            @endforeach
        </small>
    </div>
@else
    <div class="assigned-users mb-2">
        <!-- <small class="text-muted">
            <i class="fas fa-user"></i> غير مسند لأحدaaa
        </small> -->
    </div>
@endif
