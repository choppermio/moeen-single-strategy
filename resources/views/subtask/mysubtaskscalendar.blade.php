@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp
 
@section('content')
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container-fluid">
    <x-page-heading :title="'التقويم الخاص بالمهام'"  />

    <div id='calendar'></div>
   
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
  <style>
.strike {
    text-decoration: line-through !important;
   opacity: 0.4;

}

  </style>
    <script>
        function resizeCalendar(calendarView) {
    if(calendarView.name === 'agendaWeek' || calendarView.name === 'agendaDay') {
        // if height is too big for these views, then scrollbars will be hidden
        calendarView.setHeight(9999);
    }
}
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            contentHeight: "auto",
            locale: 'ar', // set the locale to Arabic
            direction: 'rtl', // set the direction to RTL
            //start from staurday
            firstDay: 6,
            //make hover effect
            eventDisplay: 'block',
            initialView: 'dayGridMonth',
            events: [
                @foreach($subtasks as $subtask)
                {
                    title  : '{{ $subtask->name }}',
                    start  : '{{ $subtask->start_date }}',
                    end    : '{{ $subtask->due_time }}',
                    @if($subtask->percentage != 100)
                    url    : '{{ url('mysubtasks-evidence/'.$subtask->id) }}',
                    @endif
                    //add strike line if the task is completed
                    @if($subtask->percentage == 100)
                    classNames: ['strike'],
                    @endif
                    color  : '{{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}' // generates a random color for each event
                },
                @endforeach
            ]
        });
        calendar.render();
    });
    </script>
@endsection