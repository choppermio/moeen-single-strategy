@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <x-page-heading :title="'تعديل الصلاحية: ' . $permission->display_name" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> تعديل الصلاحية
                    </h6>
                </div>
                <div class="card-body">
                    <form id="editPermissionForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">الاسم التقني <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           value="{{ $permission->name }}"
                                           required>
                                    <small class="form-text text-muted">
                                        يُستخدم في الكود البرمجي (بدون مسافات، أحرف إنجليزية صغيرة فقط)
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="display_name">الاسم المعروض <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="display_name" 
                                           name="display_name" 
                                           value="{{ $permission->display_name }}"
                                           required>
                                    <small class="form-text text-muted">
                                        الاسم الذي سيظهر للمستخدمين
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ $permission->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="group">المجموعة <span class="text-danger">*</span></label>
                                    <select class="form-control" id="group" name="group" required>
                                        <option value="">-- اختر المجموعة --</option>
                                        @foreach($groups as $key => $value)
                                            <option value="{{ $key }}" {{ $permission->group == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="route">المسار (اختياري)</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="route" 
                                           name="route" 
                                           value="{{ $permission->route }}">
                                    <small class="form-text text-muted">
                                        مسار Laravel المرتبط بهذه الصلاحية
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> حفظ التغييرات
                            </button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> العودة
                            </a>
                            <button type="button" class="btn btn-danger float-right" id="deletePermissionBtn">
                                <i class="fas fa-trash"></i> حذف الصلاحية
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle"></i> معلومات الصلاحية
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $permission->id }}</p>
                    <p><strong>تاريخ الإنشاء:</strong> {{ $permission->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>آخر تحديث:</strong> {{ $permission->updated_at->format('Y-m-d H:i') }}</p>
                    
                    <hr>
                    
                    <h6>المناصب المخصصة لها:</h6>
                    @if($permission->employeePositions->count() > 0)
                        <ul class="small">
                            @foreach($permission->employeePositions as $position)
                                <li>{{ $position->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small">لم يتم تخصيصها لأي منصب بعد</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Form submission
    $('#editPermissionForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        
        // Disable submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: '{{ route("permissions.updatePermission", $permission->id) }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'تم!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'موافق'
                    });
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors || {};
                var errorMessage = 'حدث خطأ أثناء حفظ التغييرات';
                
                if (Object.keys(errors).length > 0) {
                    errorMessage = Object.values(errors).flat().join('\n');
                }
                
                Swal.fire({
                    title: 'خطأ!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'موافق'
                });
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Delete permission
    $('#deletePermissionBtn').on('click', function() {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'سيتم حذف الصلاحية نهائياً ولن يمكن استعادتها!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("permissions.destroy", $permission->id) }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'تم الحذف!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'موافق'
                            }).then(() => {
                                window.location.href = '{{ route("permissions.index") }}';
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON?.message || 'حدث خطأ أثناء حذف الصلاحية';
                        Swal.fire({
                            title: 'خطأ!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'موافق'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
@endsection