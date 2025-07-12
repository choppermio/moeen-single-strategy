<style>

    .badge{color:white!important;}
</style>
<table class="table table-striped">
    <thead>
        <tr>
            <th>من</th>
            <th>الى</th>
            <th>الحالة</th>
            <th>التاريخ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ticket_transitions as $ticket_transition)
        <tr>
            {{-- <td>{{ $ticket_transition->to_state }}</td> --}}
            <td>{{ $ticket_transition->from_state == 1 ?'مكتب الإستراتيجية' :\App\Models\EmployeePosition::where('id', $ticket_transition->from_state)->first()->name }}</td>
            <td>{{ $ticket_transition->to_state == 1 ?'مكتب الإستراتيجية' :\App\Models\EmployeePosition::where('id', $ticket_transition->to_state)->first()->name  }}</td>
            <td> 
@switch($ticket_transition->status)
@case('sent')
<span class="badge bg-primary">تم إرسال الطلب</span>
@break
@case('accept')
<span class="badge bg-info">تم قبول التذكرة</span>
@break

@case('approved')
<span class="badge bg-info">تم قبول التذكرة</span>
@break


@case('rejected')
<span class="badge bg-danger">تم رفض الطلب</span>
@break
@case('attachment-added')
<span class="badge bg-info">تم إضافة مرفق</span>
@break
@case('strategy-pending-approval')
<span class="badge bg-warning text-dark">بانتظار موافقة قسم الإستراتيجية</span>
@break
@case('strategy-rejected')
<span class="badge bg-danger">تم الرفض من قسم الإستراتيجية</span>
@break
@case('strategy-approved')
<span class="badge bg-success">تم القبول</span>
@break
@case('transfered-to-team-member')
<span class="badge bg-info">تم تحويل الطلب لموظف</span>
@break
                    
                @break
                @default
                    <span class="badge bg-secondary">غير معروف</span>
            @endswitch
            </td>
            <td dir="rtl"><span class="badge badge-secondary">{{ \Carbon\Carbon::parse($ticket_transition->created_at)->format('d-m-Y') }} | {{ \Carbon\Carbon::parse($ticket_transition->created_at)->format('h:i') }} {{ \Carbon\Carbon::parse($ticket_transition->created_at)->format('A') == 'AM' ? 'ص' : 'م' }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>

