@php
    $hadafstrategies = \App\Models\Hadafstrategy::all();
  
@endphp

<ul dir="rtl">
@foreach ($hadafstrategies as $hadafstrategy )
<li>
{{ $hadafstrategy->name }}  | {{ $hadafstrategy->percentage }} %




@php

// here is the the strategy moashers
    $moasheradastrategies = \App\Models\Moasheradastrategy::where('parent_id',$hadafstrategy->id)->get();
    
@endphp

@foreach ($moasheradastrategies as $moasheradastrategy )
<ul>
<li>
{{ $moasheradastrategy->name }}  | {{ $moasheradastrategy->percentage }} %
@php
    //dd($moasheradastrategy->mobadaras);
@endphp
<ul>
@foreach ($moasheradastrategy->mobadaras as $mobadara )

<li>
{{ $mobadara->name }}  | {{ $mobadara->percentage }} %



@php
    $moashermkmfs = \App\Models\Moashermkmf::where('parent_id',$mobadara->id)->get();
@endphp
<ul>
    @foreach ($moashermkmfs as $moashermkmf)
        <li>
            {{ $moashermkmf->name }}  | {{ $moashermkmf->percentage }} %
            @php
                 $tasks = \App\Models\Task::where('parent_id',$moashermkmf->id)->get();
            @endphp
            <ul>
                @foreach ($tasks as $task)
                    <li>
                        {{ $task->name }}  | {{ $task->percentage }} %

                        @php
                        $subtasks = \App\Models\Subtask::where('parent_id',$task->id)->get();
                   @endphp
                     <ul>
                          @foreach ($subtasks as $subtask)
                            <li>
                                 {{ $subtask->name }}  | {{ $subtask->percentage }} %
                            </li>
                          @endforeach
                        </ul>

                    </li>
                @endforeach
            </ul>

        </li>
    @endforeach
</ul>
</li>

@endforeach
</ul>
</li>
</ul>
@endforeach

</li>

<br />
@endforeach
</ul>