@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <x-page-heading :title="'إضافة صلاحية جديدة'" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus"></i> إنشاء صلاحية جديدة
                    </h6>
                </div>
                <div class="card-body">
                    <form id="createPermissionForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">الاسم التقني <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           placeholder="مثال: manage_reports"
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
                                           placeholder="مثال: إدارة التقارير"
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
                                      rows="3"
                                      placeholder="وصف مختصر لما تتيحه هذه الصلاحية"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="group">المجموعة <span class="text-danger">*</span></label>
                                    <select class="form-control" id="group" name="group" required>
                                        <option value="">-- اختر المجموعة --</option>
                                        @foreach($groups as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
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
                                           placeholder="مثال: reports.* أو reports.index">
                                    <small class="form-text text-muted">
                                        مسار Laravel المرتبط بهذه الصلاحية
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> إنشاء الصلاحية
                            </button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> العودة
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle"></i> إرشادات
                    </h6>
                </div>
                <div class="card-body">
                    <h6>قواعد تسمية الصلاحيات:</h6>
                    <ul class="small">
                        <li><strong>الاسم التقني:</strong> أحرف إنجليزية صغيرة، أرقام، وشرطة سفلية فقط</li>
                        <li><strong>استخدم الأفعال:</strong> view, create, edit, delete, manage</li>
                        <li><strong>أمثلة جيدة:</strong> view_reports, manage_users, delete_files</li>
                    </ul>

                    <hr>

                    <h6>المجموعات المتاحة:</h6>
                    <ul class="small">
                        @foreach($groups as $key => $value)
                            <li><code>{{ $key }}</code> - {{ $value }}</li>
                        @endforeach
                    </ul>

                    <hr>

                    <h6>أمثلة على المسارات:</h6>
                    <ul class="small">
                        <li><code>reports.*</code> - جميع مسارات التقارير</li>
                        <li><code>reports.index</code> - عرض التقارير فقط</li>
                        <li><code>users/create</code> - صفحة إنشاء مستخدم</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate technical name from display name
    $('#display_name').on('input', function() {
        var displayName = $(this).val();
        var technicalName = displayName
            .toLowerCase()
            .replace(/[أ-ي]/g, '') // Remove Arabic characters
            .replace(/\s+/g, '_') // Replace spaces with underscores
            .replace(/[^a-z0-9_]/g, '') // Remove special characters
            .replace(/_+/g, '_') // Replace multiple underscores with single
            .replace(/^_|_$/g, ''); // Remove leading/trailing underscores
        
        if (technicalName && $('#name').val() === '') {
            $('#name').val(technicalName);
        }
    });

    // Form submission
    $('#createPermissionForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        
        // Disable submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الإنشاء...');
        
        $.ajax({
            url: '{{ route("permissions.store") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        title: 'تم!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'موافق'
                    }).then((result) => {
                        // Redirect to permissions index
                        window.location.href = '{{ route("permissions.index") }}';
                    });
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors || {};
                var errorMessage = 'حدث خطأ أثناء إنشاء الصلاحية';
                
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
});
</script>
@endpush
@endsection