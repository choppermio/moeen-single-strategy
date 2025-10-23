{{-- resources/views/partials/tasks.blade.php --}}
<select name="task_id" id="task_id" class="form-control" required>
    <option value="0">بدون اختيار</option>
    @foreach ($tasks as $task)
        <option value="{{ $task->id }}" @if($task->hidden==1) disabled @endif>{{ $task->name }} 
        @php
            $mubadara_name = \App\Models\Mubadara::where('id',$task->parent_id)->first()->name;
            @endphp

        ( {{$mubadara_name }})  ({{ $task->output }})
        </option>
    @endforeach
</select>
