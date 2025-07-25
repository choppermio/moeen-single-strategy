@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<style type="text/css">
    .dropdown-toggle{
        height: 40px;
        width: 400px !important;
    }
</style>
<div class="container">

    <x-page-heading :title="'تعديل اجراء'"  />


    <form method="post" action="{{ route('task.update', $task->id) }}">
        @csrf
        @method('PUT') <!-- This directive is required to simulate a PUT request -->

<div class="form-group">
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name" value="{{ $task->name }}"/>
</div>




<div class="mb-3">
    <label for="output" class="form-label">المخرج</label>
    <textarea class="form-control" name="output">{{ $task->output }}</textarea>
</div>



<div class="mb-3">
    <label for="marketing_cost" class="form-label">التكلفة المالية المطروحة للتسويق</label>
    <input type="number" class="form-control" id="marketing_cost" name="marketing_cost" required value="{{ $item->marketing_cost }}">
</div>

<div class="mb-3">
    <label for="real_cost" class="form-label">التكلفة المالية المعدة للإجراء</label>
    <input type="number" class="form-control" id="real_cost" name="real_cost" required value="{{ $item->real_cost }}">
</div>

<div class="mb-3">
    <label for="sp_week" class="form-label">اسبوع بداية التنفيذ المخطط له</label>
    <input type="date" class="form-control" id="sp_week" name="sp_week" required value="{{ $item->sp_week }}">
</div>

<div class="mb-3">
    <label for="ep_week" class="form-label">اسبوع نهاية التنفيذ المخطط له</label>
    <input type="date" class="form-control"  id="ep_week" name="ep_week" required value="{{ $item->ep_week }}">
</div>

<div class="mb-3">
    <label for="sr_week" class="form-label">اسبوع بداية التنفيذ الفعلي</label>
    <input type="date" class="form-control" disabled id="sr_week" name="sr_week" required value="{{ $item->sr_week }}">
</div>

<div class="mb-3">
    <label for="er_week" class="form-label">اسبوع نهاية التنفيذ الفعلي</label>
    <input type="date" class="form-control" disabled id="er_week" name="er_week" required value="{{ $item->er_week }}">
</div>

<div class="mb-3">
    <label for="r_money_paid" class="form-label">التكلفة الفعلية (المصروف الفعلي)</label>
    <input type="number" class="form-control" id="r_money_paid" name="r_money_paid" required value="{{ $item->r_money_paid }}">
</div>

<div class="mb-3">
    <label for="marketing_verified" class="form-check-label" for="marketing_verified">المتحقق من التسويق</label>

    <input type="number" class="form-control" id="marketing_verified" name="marketing_verified" required value="{{ $item->marketing_verified }}">
</div>

<div class="mb-3">
    <label for="complete_percentage" class="form-label">اكتمال التنفيذ</label>
    <input type="number" class="form-control" id="complete_percentage" name="complete_percentage" required min="0" max="100"  value="{{ $item->complete_percentage }}">
</div>

<div class="mb-3">
    <label for="quality_percentage" class="form-label">نسبة توافر الشواهد</label>
    <input type="number" class="form-control" id="quality_percentage" name="quality_percentage" required min="0" max="100"  value="{{ $item->quality_percentage }}">
</div>

<div class="mb-3">
    <label for="evidence" class="form-label">توافر الشواهد</label>
    <input type="number" class="form-control" id="evidence" name="evidence"  value="{{ $item->evidence }}">
</div>

<div class="mb-3">
    <label for="roi" class="form-label">العائد على الإستثمار</label>
    <input type="number" class="form-control" id="roi" name="roi" required  value="{{ $item->roi }}">
</div>

<div class="mb-3">
    <label for="customers_count" class="form-label">عدد المستفيدين</label>
    <input type="number" class="form-control" id="customers_count" name="customers_count" required  value="{{ $item->customers_count }}">
</div>

<div class="mb-3">
    <label for="perf_note" class="form-label">تبرير الأداء</label>
    <textarea class="form-control" id="perf_note" name="perf_note" rows="3">{{ $item->perf_note }}</textarea>
</div>

<div class="mb-3 form-check">
    <label class="form-check-label" for="recomm">التوصيات</label>
    <textarea class="form-control" id="recomm" name="recomm" rows="3">{{ $item->recomm }}</textarea>

</div>

<div class="mb-3">
    <label for="notes" class="form-label">ملاحظات</label>
    <textarea class="form-control" id="notes" name="notes" rows="3">{{ $item->notes }}</textarea>
</div>






<div class="mb-3 d-none">
    <label for="user" class="form-label">العضو</label>
    <input type="number" class="form-control" id="user" name="user" placeholder="Enter user">
</div>




<div class="form-group">
   <!-- For select inputs, ensure the correct option is marked as selected based on the task data -->
   <div class="form-group">
    <label for="name">مؤشرات الكفاءة والفعالية</label>
    <select class="selectpicker" multiple data-live-search="true" name="moashermkmfs[]">
        @foreach ($moashermkmfs as $moashermkmf)
            <option value="{{ $moashermkmf->id }}" @if(in_array($moashermkmf->id, $task->moashermkmfs->pluck('id')->toArray())) selected @endif>{{ $moashermkmf->name }}</option>
        @endforeach
    </select>
</div>
    <input type="hidden" value="{{$mubadara}}" name="mubadara" />
    </div>

 

<div class="form-group">
    <button class="btn btn-primary">تحديث</button>
    </div>
</form>
</div>
@endsection