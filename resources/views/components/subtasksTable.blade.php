@if($subtasks->count() > 0)
<style>
    td 
{
    height: 50px; 
    width: 50px;
}

#cssTable td 
{
    text-align: right; 
    vertical-align: middle;
}
    </style>
<table class="table table-bordered table-mobile-responsive" id="cssTable">
    <thead>
        <tr>
            <th>#</th>
            {{-- <th>المبادرة</th>
            <th>الإجراء الرئيسي</th> --}}
            <th>المهمة</th>
            <th>وصف المهمة</th>
            <th>منشئ المهمة </th>
            <th>المرفقات</th>
            
            <th>الوقت المتوقع للإنهاء</th>
            <th>نسبة الإكتمال</th>
            <th>الشواهد</th>
            @if($children_employee_positions->count() > 0)
            <th>إسناد لأعضاء إدارتي</th>
            @endif
            <th>ملاحظات</th>
            <th>عرض التحديثات</th>
            <th>إجراء</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subtasks as $subtask)
        
        @php
            $task = \App\Models\Task::where('id', $subtask->parent_id)->first();
            $mubadara = null;
            if ($task) {
                $mubadara = \App\Models\Mubadara::where('id', $task->parent_id)->first();
            }
        @endphp
        <tr>
            <td data-content="رقم المهمة">{{ $subtask->ticket_id }}</td>
            {{-- <td>{{ $mubadara->name ?? 'N/A' }}</td>
            <td>{{ $task->name ?? 'N/A' }}</td> --}}
            <td data-content="اسم المهمة">{{ $subtask->name }}
                <div class="mt-2">
        <span class="badge badge-info"  style="word-break: break-all;">مبادرة : {{ $mubadara->name ?? 'N/A' }}</span>
<br />             
        <span class="" style="    overflow-wrap: break-word;
    width: 100%;
    color: #fff;
    background-color: #6c757d;
    padding: 3px;
    border-radius: 30px;
    font-size: 12px;
    display: block;
    margin-top: 0.4em;
    text-align: right; padding-right: 5px; font-weight: bold;" class="pr-1">إجراء : {{ $task->name ?? 'N/A' }} </span>     

<span class="badge badge-primary mt-1 ">مخرج الإجراء : {{ $task->output ?? 'N/A' }}</span>
</div>

            </td>
            <td data-content="وصف المهمة">
                
                <div style="width:200px;">
                    @php
                    $note = \App\Models\Ticket::where('id',$subtask->ticket_id)->first()->note ?? '';
                    $uniqueId =  $subtask->ticket_id;
                    @endphp
                    <div id="shortNote_{{ $uniqueId }}" class="collapse show">
                        {{ Str::limit($note, 30) }}
                        @if(strlen($note) > 30)
                            <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
                        @endif
                    </div>
                    <div id="fullNote_{{ $uniqueId }}" class="collapse">
                        {{ $note }}
                        <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
                    </div>                </div>

                <!-- Display assigned users for this subtask -->
                <div class="mt-2">
                    <x-assigned-users :type="'subtask'" :id="$subtask->id" />
                </div>

                </td>
                
                <td>
                @php
                        $ticket = \App\Models\Ticket::where('id', $subtask->ticket_id)->first();
                        if(isset($ticket->from_id)){
                            $from  =   \App\Models\EmployeePosition::where('id',$ticket->from_id)->first()->name  ;
                        }
                     
                    @endphp
                    <span class="badge badge-secondary"> {{ $from ?? '' }}</span>
                </td>
            <td data-content="المرفقات">
                
                    @php
                       
                        // dd($ticket);
                        // dd($ticket);
                    @endphp
                    @if($ticket && $ticket->images)

                    @foreach ($ticket->images as $image)
                    <a href="                    @php
                    // Remove "public/" from the filepath since storage link maps /storage to /storage/app/public
                    $cleanPath = str_replace('public/', '', $image->filepath);
                    $newFilePath = url('/storage/'.$cleanPath);
                    echo $newFilePath;
                    @endphp
                    " target="_blank" >{{ $image->filename }}</a><hr />
                        
                    @endforeach
                    @endif
                   
            </td>
            <td data-content="الوقت المتوقع للإنتهاء">
                @if ($subtask->due_time < $subtask->done_time)
                    <span class="badge badge-danger">
                @else
                    <span class="badge badge-info">
                @endif                @php
                $dateTimeString =  $subtask->due_time;

// Parse the string into a Carbon instance
$dateTime = \Carbon\Carbon::parse($dateTimeString);

// Convert to 12-hour format
$dateTimeIn12HourFormat = $dateTime->format('Y-m-d h:i:s A'); // Example: "2024-02-07 11:19:00 PM"

// Output the result
echo $dateTimeIn12HourFormat;
                @endphp
                 </span>
               </td>
            <td data-content="نسبة الإكتمال">{{ $subtask->percentage }} %</td>
            <td data-content="الشواهد">
                @if($no_evidence == 0)
                    <a href="{{ url(env('APP_URL_REAL') . '/mysubtasks-evidence/' . $subtask->id) }}" target="_blank">الشواهد</a>
                    @if($subtask->getMedia('images')->count() > 0) 
                    <a href="{{ $subtask->getMedia('images')[0]->getUrl() }}" target="_blank">تحميل</a> 
                    @endif
                @endif
           
            </td>
            @if($children_employee_positions->count() > 0)
            <td data-content="رقم التذكرة">
                @if($no_evidence == 0)
                <!-- Button trigger modal -->
                <button type="button" subtask="{{$subtask->id}}" class="btn btn-primary  btn-sm button-change-user" data-toggle="modal" data-target="#exampleModal2">
                    <i class="fas fa-user"></i>
                </button>
                @endif
            </td>
            @endif
            
            <td data-content="ملاحظات">
            
                <div style="width:200px;">
                    @php
                    $note = $subtask->notes ?? '';
                    $uniqueId =  uniqid();
                    @endphp
                    <div id="shortNote_{{ $uniqueId }}" class="collapse show">
                        {{ Str::limit($note, 30) }}
                        @if(strlen($note) > 30)
                            <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة المزيد</a>
                        @endif
                    </div>
                    <div id="fullNote_{{ $uniqueId }}" class="collapse">
                        {{ $note }}
                        <a href="#" data-toggle="collapse" data-target="#shortNote_{{ $uniqueId }},#fullNote_{{ $uniqueId }}">قراءة أقل</a>
                    </div>
                </div>
            </td>
            <td data-content="التحديثات"><a href="{{ url(env('APP_URL_REAL')) }}/ticketsshow/{{ $subtask->ticket_id }}" target="_blank">عرض</a></td>
            <td data-content="إجراء">
            
            @if($subtask->user_id != current_user_position()->id)
                <button type="button" class="btn btn-primary  btn-sm button-change-status" data-toggle="modal" data-target="#exampleModal" subtask="{{$subtask->id}}">
                    تعديل الإجراء
                </button>
            @endif
                
                    

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>لايوجد مهام</p>
@endif
<!-- Modal for changing satus -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="changetaskform" action="{{ route('subtask.changeTask') }}">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">تعديل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                    @csrf
                    <div class="mb-3">
                        <h2 class="form-label taskname"></label>
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">الحالة</label>
                        <select class="form-control" id="taskStatus" name="task_id" required>
                           @php
                           //$tasks equal all the tasks where user_id is $user_id and store it in php variable
                           $tasks = \App\Models\Task::where('user_id', $user_id)->get();
                           
                           @endphp
                            @foreach($tasks as $task)
                            <option value="{{$task->id}}">{{$task->name}}</option>
                            @endforeach
                        </select>
<input type="hidden" name="subtask_id"/>

                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلاق</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
        </div>
    </div>
</div>
