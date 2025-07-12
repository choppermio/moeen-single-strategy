@extends('layouts.admin')
@section('content')
<style>

    .badge{color:white!important;}
    .modal-lg {
    max-width: 80% !important;
}
</style>
<div class="container">
    <h1>اسم المهمة : {{ $ticket->name }}</h1>
    <hr />
    {{-- <p>{{ $ticket->description }}</p> --}}

    <h2>التحديثات</h2>
    @if($ticket->messages->isEmpty())
        <p>لاتوجد تحديثات.</p>
    @else
      

    @foreach($ticket->messages as $message)
        <div class="card mb-3">
            <div class="card-body">
               
                <p class="card-text">{{ $message->content }}</p>
                <div class="row" style="background: #f5f5f5;
                padding: 5px;
                padding-top: 10px;
                font-size: 13px;">
                    <div class="col-3"><h6 class="card-title">{{ $message->user->name }}</h6></div>
                    <div class="col-9"><p style="float: right;" class="card-text"><small class="text-muted">تمت الإضافة {{ $message->created_at->format('F j, Y, g:i a') }}</small></p></div>
                </div>
                
                
            </div>
        </div>
    @endforeach
    @endif
    <h5>اضف تحديث على المهمة</h5>
    <form action="{{ route('tickets.messages.store', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">إرسال</button>
    </form>
</div>
@endsection
