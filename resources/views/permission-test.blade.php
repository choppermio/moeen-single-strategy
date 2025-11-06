@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">اختبار الصلاحيات</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات المنصب الحالي</h6>
                </div>
                <div class="card-body">
                    @if($userPosition)
                        <p><strong>المنصب:</strong> {{ $userPosition->name }}</p>
                        <p><strong>المستخدم:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>عدد الصلاحيات:</strong> {{ $userPermissions->count() }}</p>
                    @else
                        <p class="text-danger">لم يتم تعيين منصب لهذا المستخدم</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">اختبار الصلاحيات</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>اختبر صلاحية:</label>
                        <select class="form-control" id="permissionSelect">
                            <option value="">اختر صلاحية للاختبار</option>
                            @foreach($allPermissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="testPermission()">اختبر</button>
                    <div id="testResult" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">صلاحياتي الحالية</h6>
                </div>
                <div class="card-body">
                    @if($userPermissions->count() > 0)
                        <div class="row">
                            @foreach($userPermissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <span class="badge badge-success p-2">
                                        {{ $permission->display_name }}
                                        <small class="d-block">{{ $permission->name }}</small>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-warning">لا توجد صلاحيات مخصصة لمنصبك حالياً</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">جميع الصلاحيات المتاحة</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>الاسم التقني</th>
                                    <th>الاسم المعروض</th>
                                    <th>الوصف</th>
                                    <th>المجموعة</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allPermissions as $permission)
                                    <tr>
                                        <td><code>{{ $permission->name }}</code></td>
                                        <td>{{ $permission->display_name }}</td>
                                        <td>{{ $permission->description }}</td>
                                        <td>{{ $permission->group }}</td>
                                        <td>
                                            @if($userPermissions->contains('id', $permission->id))
                                                <span class="badge badge-success">✓ ممنوحة</span>
                                            @else
                                                <span class="badge badge-secondary">✗ غير ممنوحة</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testPermission() {
    const permission = document.getElementById('permissionSelect').value;
    const resultDiv = document.getElementById('testResult');
    
    if (!permission) {
        resultDiv.innerHTML = '<div class="alert alert-warning">يرجى اختيار صلاحية للاختبار</div>';
        return;
    }
    
    resultDiv.innerHTML = '<div class="text-info">جاري الاختبار...</div>';
    
    fetch(`/permission-test/${permission}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            resultDiv.innerHTML = `<div class="alert alert-danger">خطأ في الاتصال: ${error.message}</div>`;
        });
}
</script>
@endsection