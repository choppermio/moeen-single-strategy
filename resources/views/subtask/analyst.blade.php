@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);
// dd($tasks);
@endphp

@section('content')



@php
// $file = \App\Models\Subtask::find(1)->getMedia('images');


@endphp
{{-- <a href="{{$file[0]->getUrl()}}">m</a> --}}
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
    .color-white{
        color: white;
    }
</style>
<style>
    #monthSelectorContainer {
        display: none;
    }
    .p-2 {
        padding: 20px;
    }
    .p-top-bottom{
        padding-top: 20px !important;
        padding-bottom: 20px !important;
        border-radius: 20px;
        /*box shadow gray 2*/
        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);
    
    }
    .bg-white{
        background-color: white;
        padding: 20px;
        box-shadow: 0 2px 4px 0 rgba(75, 75, 75, 0.2);
    }
    .w-50{
        width: 50%;
    }
    .font-bold{
        font-weight: bold;
    }
</style>
<div class="container">

    <div id="monthSelectorContainer " class="bg-white">
        <label for="monthSelector">اختر شهراً للفلترة</label>
        <select id="monthSelector" onchange="updateURL()">
            <option value="01" @if(date('m') == $_GET['id']) selected @endif>يناير</option>
            <option value="02" @if(date('m') == $_GET['id']) selected @endif>فبراير</option>
            <option value="03" @if(date('m') == $_GET['id']) selected @endif>مارس</option>
            <option value="04" @if(date('m') == $_GET['id']) selected @endif>أبريل</option>
            <option value="05" @if(date('m') == $_GET['id']) selected @endif>مايو</option>
            <option value="06" @if(date('m') == $_GET['id']) selected @endif>يونيو</option>
            <option value="07" @if(date('m') == $_GET['id']) selected @endif>يوليو</option>
            <option value="08" @if(date('m') == $_GET['id']) selected @endif>أغسطس</option>
            <option value="09" @if(date('m') == $_GET['id']) selected @endif>سبتمبر</option>
            <option value="10" @if(date('m') == $_GET['id']) selected @endif>أكتوبر</option>
            <option value="11" @if(date('m') == $_GET['id']) selected @endif>نوفمبر</option>
            <option value="12" @if(date('m') == $_GET['id']) selected @endif>ديسمبر</option>
        </select>
    </div>

    @if(isset($_GET['type']) == 'year')
    <x-page-heading :title="'تقرير السنة الحالية'"  />
    @endif

  

 
    <div class="row text-center bg-white font-bold">
        <div class="col-md-2">
            <div class="bg-secondary color-white p-2 p-top-bottom">
                <i class="fas fa-tasks"></i> المهام الإجمالية
                <div>{{ $strategy_pending_subtasks + $pending_approval_subtasks + $done_subtasks + $current_subtasks }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="bg-info color-white p-2 p-top-bottom font-bold">
                <i class="fas fa-spinner"></i> المهام الحالية
                <div>{{ $current_subtasks }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="bg-info color-white p-2 p-top-bottom font-bold">
                <i class="fas fa-clock"></i>  تحت الموافقة
                <div>{{ $strategy_pending_subtasks + $pending_approval_subtasks }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="bg-danger color-white p-2 p-top-bottom font-bold">
                <i class="fas fa-exclamation-triangle"></i> المهام المتعثرة
                <div>{{ $stumble_subtasks }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="bg-success color-white p-2 p-top-bottom">
                <i class="fas fa-check"></i> المهام المنجزة
            
            <div>{{ $done_subtasks }}</div>
        </div>
        </div>
    </div>

    <div class="bg-white mt-3">
        <canvas id="barchart" width="400" height="200"></canvas>
            </div>


    <div class="bg-white mt-3 w-50">
<canvas id="myPieChart" ></canvas>
    </div>

    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@php
// dd($monthlyPending);
@endphp
<script>
    var ctx = document.getElementById('barchart').getContext('2d');
    var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'المنتهية',
                    data: @json($monthlyDone),
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'الحالية ',
                    data: @json($monthlyPending),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'المتعثرة',
                    data: @json($monthlyStumble),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'معلقة في قسم الإستراتيجية ',
                    data: @json($monthlyStrategyPending),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        stacked: false,
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true
                    }
                }
            }
        });
</script>
<script>
    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['المهام المتعثرة', 'المهام تحت الموافقة', 'المهام الحالية', 'المهام المنجزة'],
            datasets: [{
                data: @json($data),
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false, // Add this to maintain the aspect ratio you've set
            plugins: {
                legend: {
                    display: true,
                },
                datalabels: {
                    color: '#000000',
                    textAlign: 'center',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value, ctx) => {
                        let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = (value / sum * 100).toFixed(2) + "%";
                        return ctx.chart.data.labels[ctx.dataIndex] + '\n' + percentage;
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>


<script>
    function updateURL() {
        var selector = document.getElementById('monthSelector');
        var selectedValue = selector.value;
        var urlParams = new URLSearchParams(window.location.search);
        urlParams.set('id', selectedValue);
        var newURL = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + urlParams.toString();
        window.location.href = newURL;
    }
    
    function showMonthSelectorIfNeeded() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('type') === 'month') {
            document.getElementById('monthSelectorContainer').style.display = 'block';
            var currentId = urlParams.get('id');
            if (currentId) {
                document.getElementById('monthSelector').value = currentId;
            }
        }
    }
    
    document.addEventListener('DOMContentLoaded', showMonthSelectorIfNeeded);
    </script>
    
@endsection