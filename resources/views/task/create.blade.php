@extends('layouts.admin')

@php
// if($moashermkmfs->count() == 0){
//     dd('يرجى ادخال اولا مؤشر كفاءة وفاعلية');
// }
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- Bootstrap Select CSS - matching the JS version 1.13.14 loaded in admin layout -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css" />
<!-- Note: jQuery, Bootstrap JS, and Bootstrap Select JS are already loaded in admin.blade.php -->
<style type="text/css">
    .dropdown-toggle{
        height: 40px;
        width: 400px !important;
    }
</style>
<div class="container">

    <x-page-heading :title="'إنشاء إجراء'"  />

<form method="post" action="{{ route('task.store') }}">
    @csrf
<div class="form-group">
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name" required/>
</div>




<div class="mb-3">
    <label for="output" class="form-label">المخرج</label>
    <textarea class="form-control" name="output" required></textarea>
</div>



<div class="mb-3">
    <label for="marketing_cost" class="form-label">التكلفة المالية المطروحة للتسويق</label>
    <input type="number" class="form-control" id="marketing_cost" name="marketing_cost" required>
</div>

<div class="mb-3">
    <label for="real_cost" class="form-label">التكلفة المالية المعدة للإجراء</label>
    <input type="number" class="form-control" id="real_cost" name="real_cost" required>
</div>

<div class="mb-3">
    <label for="sp_week" class="form-label">اسبوع بداية التنفيذ المخطط له</label>
    <input type="date" class="form-control" id="sp_week" name="sp_week" required>
</div>

<div class="mb-3">
    <label for="ep_week" class="form-label">اسبوع نهاية التنفيذ المخطط له</label>
    <input type="date" class="form-control"  id="ep_week" name="ep_week" required>
</div>

<div class="mb-3">
    <label for="sr_week" class="form-label">اسبوع بداية التنفيذ الفعلي</label>
    <input type="date" class="form-control" disabled id="sr_week" name="sr_week" required>
</div>

<div class="mb-3">
    <label for="er_week" class="form-label">اسبوع نهاية التنفيذ الفعلي</label>
    <input type="date" class="form-control" disabled id="er_week" name="er_week" required>
</div>

<div class="mb-3">
    <label for="r_money_paid" class="form-label">التكلفة الفعلية (المصروف الفعلي)</label>
    <input type="number" class="form-control" id="r_money_paid" name="r_money_paid" required>
</div>

<div class="mb-3">
    <label for="marketing_verified" class="form-check-label" for="marketing_verified">المتحقق من التسويق</label>

    <input type="number" class="form-control" id="marketing_verified" name="marketing_verified" required>
</div>

<div class="mb-3">
    <label for="complete_percentage" class="form-label">اكتمال التنفيذ</label>
    <input type="number" class="form-control" id="complete_percentage" name="complete_percentage" required min="0" max="100" required>
</div>

<div class="mb-3">
    <label for="quality_percentage" class="form-label">نسبة توافر الشواهد</label>
    <input type="number" class="form-control" id="quality_percentage" name="quality_percentage" required min="0" max="100" required>
</div>

<div class="mb-3">
    <label for="evidence" class="form-label">توافر الشواهد</label>
    <input type="number" class="form-control" id="evidence" name="evidence" required>
</div>

<div class="mb-3">
    <label for="roi" class="form-label">العائد على الإستثمار</label>
    <input type="number" class="form-control" id="roi" name="roi" required>
</div>

<div class="mb-3">
    <label for="customers_count" class="form-label">عدد المستفيدين</label>
    <input type="number" class="form-control" id="customers_count" name="customers_count" required>
</div>

<div class="mb-3">
    <label for="perf_note" class="form-label">تبرير الأداء</label>
    <textarea class="form-control" id="perf_note" name="perf_note" rows="3" required></textarea>
</div>

<div class="mb-3 form-check">
    <label class="form-check-label" for="recomm">التوصيات</label>
    <textarea class="form-control" id="recomm" name="recomm" rows="3" required></textarea>

</div>

<div class="mb-3">
    <label for="notes" class="form-label">ملاحظات</label>
    <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
</div>






<div class="mb-3 d-none">
    <label for="user" class="form-label">العضو</label>
    <input type="number" class="form-control" id="user" name="user" placeholder="Enter user" >
</div>




<div class="form-group">
    <label for="name">مؤشرات الكفاءة والفعالية</label>
    <select  class="selectpicker" multiple data-live-search="true" name="moashermkmfs[]" required>
        @foreach ($moashermkmfs as $moashermkmf)
        <option value="{{ $moashermkmf->id }}">{{ $moashermkmf->name }}</option>
        @endforeach
    </select>
    <input type="hidden" value="{{$mubadara}}" name="mubadara" />
    </div>

 

<div class="form-group">
    <button class="btn btn-primary">حفظ</button>
</form>
</div>

<script>
// Wait for all libraries to load, then initialize Bootstrap Select
$(window).on('load', function() {
    setTimeout(function() {
        // Destroy any existing Bootstrap Select instances first
        $('.selectpicker').selectpicker('destroy');
        
        // Initialize Bootstrap Select fresh
        $('.selectpicker').selectpicker({
            liveSearch: true,
            style: 'btn-outline-secondary',
            size: 10
        });
    }, 100);
});
</script>

@endsection