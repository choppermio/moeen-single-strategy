@extends('layouts.admin')

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <x-page-heading :title="'الأهداف الإستراتيجية'"  />

    <a href="{{url('/hadafstrategies/create')}}"><button >أضف جديد</button></a>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr >
                <th style="text-align:right;">إسم الهدف</th>
                <th style="text-align:right;">المؤشرات</th>
                <th style="text-align:right;">النسبة</th>
                <th style="display:none;">المدير</th>
                <th style="text-align:right;">الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hadafstrategies as $strategy)
            <tr>
                <td>{{ $strategy->name }} </td>
                     <td>
                     @php
            // Assuming you have sanitized and validated the input
            $parentId = $strategy->id; // Using Laravel's request helper for better security
            // dd($parentId);
            $items = \App\Models\Moasheradastrategy::where('parent_id', $parentId)->get();
            @endphp
            
            @if($items->isNotEmpty())
                <table style="font-size: 13px; background:e1e1e1;" class="table table-striped">
                     
                    @foreach($items as $item)
                  
                    <tr>
                        <td >{{ $item->name }}
                        
                     
                        </td> <!-- Assuming 'name' is the field you want to display -->
                        {{--<td> ( {{ \App\Models\EmployeePosition::where('id',$item->user_id)->first()->name ?? }} )</td>--}}
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No items found.</p>
            @endif
        
                    
                </td>
                <td>{{ $strategy->percentage }} %</td>
           
                @php
                @endphp
                <td style="display:none;">
                    @php
                    @endphp
                   {{ \App\Models\EmployeePosition::where('id',$strategy->user_id)->first()->name }}
                    </td>
                <td>
                    <!--<form action="{{ route('hadafstrategies.destroy', $strategy->id) }}" method="POST" style="display: inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="btn btn-danger">حذف</button>-->
                    <!--</form>-->
                    @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))))
                    <a href="{{ route('hadafstrategies.edit', $strategy->id) }}" class="btn btn-primary">تعديل</a>
                    @endif
                    <a href="newstrategy?id={{ $strategy->id }}" class="btn btn-primary">عرض</a>

                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
@endsection
