@extends('layouts.admin')
@if(isset($_GET['hadafstrategy']) && $_GET['hadafstrategy'] == '999999999999999')
    @dd('يجب إنشاء هدف استراتيجي أولا ');
@endif


@php
use App\Models\Hadafstrategy; // Make sure to use your correct namespace
use App\Models\Moasheradastrategy; // Make sure to use your correct namespace

$hadafstrategyCount = Hadafstrategy::where('id', (int)$_GET['hadafstrategy'])->count();
$moasheradastrategyCount = Moasheradastrategy::where('parent_id', (int)$_GET['hadafstrategy'])->count();

if ($hadafstrategyCount == 0 ) {
       dd('يجب إنشاء هدف استراتيجي أولا ');
       
    }
    
    if($moasheradastrategyCount == 0){
    dd('يجب إنشاء هدف مؤشر اداء استراتيجي أولا ');

}
@endphp


@php
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
    <x-page-heading :title="'إنشاء مبادرة'"  />



<form method="post" action="{{ route('mubadara.store') }}">
    @csrf
<div class="form-group">
<label for="name">الإسم:</label>
<input type="text" class="form-control" name="name" required/>
</div>

<div class="form-group">
    <label for="name">المؤشر الإستراتيجي</label>
    <select  class="selectpicker" multiple data-live-search="true" name="hadafstrategy[]" required>
        @foreach ($moasheradastrategies as $moasheradastrategy)
        <option value="{{ $moasheradastrategy->id }}">{{ $moasheradastrategy->name }}</option>
        @endforeach
    </select>
    </div>

 

    <label for="name">إسناد لعضو:</label>
    <select  class="selectpicker"  data-live-search="true" name="user_id" required>
        
        @foreach ($employee_positions as $employee_position)
        <option value="{{ $employee_position->id }}">{{ $employee_position->name }}</option>
        @endforeach
    </select>
    </div>

<div class="container">
    <div class="mb-3">
        <label for="general_desc" class="form-label">وصف عام</label>
        <textarea  class="form-control" id="general_desc" name="general_desc" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="date_from" class="form-label">التاريخ من</label>
        <input type="date" class="form-control" id="date_from" name="date_from" required>
    </div>
    
    <div class="mb-3">
        <label for="date_to" class="form-label">التاريخ الى</label>
        <input type="date" class="form-control" id="date_to" name="date_to" required>
    </div>
    
    <div class="mb-3">
        <label for="estimate_cost" class="form-label">التكلفة التقديرية</label>
        <input type="number" class="form-control" id="estimate_cost" name="estimate_cost" min="0" step="0.01" required>
    </div>
    
    <div class="mb-3">
        <label for="dangers" class="form-label">المخاطر</label>
        <textarea class="form-control" id="dangers" name="dangers" rows="4" required></textarea>
    </div>
    <div class="form-group">
    <button class="btn btn-primary">حفظ</button>
    </div>
</div>

</form>


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

document.addEventListener('DOMContentLoaded', function () {
    // Get today's date and format it as YYYY-MM-DD
   /* var today = new Date().toISOString().split('T')[0];

    // Set the min attribute for both date_from and date_to to today's date
    var dateFrom = document.getElementById('date_from');
    var dateTo = document.getElementById('date_to');
    dateFrom.setAttribute('min', today);
    dateTo.setAttribute('min', today);

    // Listen for changes in the date_to field to ensure it's after date_from
    dateTo.addEventListener('change', function () {
        // Convert the values to Date objects for comparison
        var from = new Date(dateFrom.value);
        var to = new Date(dateTo.value);

        // Check if date_to is less than or equal to date_from
        if (to <= from) {
            alert('يجب أن يكون التاريخ إلى أكبر من التاريخ من.');
            dateTo.value = ''; // Clear the date_to field if the condition is true
        }
    });
    */
    
});

document.addEventListener('DOMContentLoaded', function () {
    var estimateCostInput = document.getElementById('estimate_cost');

    estimateCostInput.addEventListener('input', function () {
        var value = parseFloat(estimateCostInput.value);
        if (value < 0) {
            estimateCostInput.value = 0; // Reset to 0 if value is less than 0
        }
    });
});
</script>

@endsection
