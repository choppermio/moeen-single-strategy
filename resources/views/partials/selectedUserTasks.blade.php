{{-- resources/views/partials/tasks.blade.php --}}
<select name="task_id" id="task_id" class="form-control" required>
    <option value="0">بدون اختيار</option>
    @foreach ($tasks as $task)
        <option value="{{ $task->id }}">{{ $task->name }} 
        @php
            $mubadara_name = \App\Models\Mubadara::where('id',$task->parent_id)->first()->name;
            @endphp

        ( {{$mubadara_name }})
        </option>
    @endforeach
</select>
