@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة الصلاحيات</h1>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> إضافة صلاحية جديدة
        </a>
    </div>

    <!-- Permission Assignment Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">تعيين الصلاحيات للمناصب الوظيفية</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6>اختر منصب وظيفي:</h6>
                    <select class="form-control" id="employeePositionSelect">
                        <option value="">-- اختر المنصب --</option>
                        @foreach($employeePositions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr />

            <div id="permissionsContainer" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">الصلاحيات المتاحة: <span id="permissionCounter" class="badge badge-info">0 محددة</span></h6>
                    <div>
                        <button type="button" class="btn btn-success btn-sm" id="selectAllPermissions">
                            <i class="fas fa-check-square"></i> تحديد جميع الصلاحيات
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" id="unselectAllPermissions">
                            <i class="fas fa-square"></i> إلغاء تحديد الكل
                        </button>
                    </div>
                </div>
                
                <form id="permissionsForm">
                    @csrf
                    <input type="hidden" id="selectedPositionId" name="position_id" />

                    @foreach($groupedPermissions as $group => $permissions)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    @php
                                        $groupNames = [
                                            'dashboard' => 'لوحة التحكم',
                                            'positions' => 'المناصب والصلاحيات',
                                            'statistics' => 'الإحصائيات',
                                            'strategy' => 'الأهداف الإستراتيجية',
                                            'team' => 'إدارة الفريق',
                                            'tasks' => 'المهام',
                                            'tickets' => 'التذاكر',
                                            'calendar' => 'التقويم',
                                            'profile' => 'الملف الشخصي',
                                            'reports' => 'التقارير',
                                            'settings' => 'الإعدادات',
                                            'general' => 'عام'
                                        ];
                                    @endphp
                                    {{ $groupNames[$group] ?? ucfirst($group) }}
                                    <div class="float-right">
                                        <input type="checkbox" class="group-checkbox" data-group="{{ $group }}"> 
                                        <small>تحديد الكل</small>
                                    </div>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" 
                                                       class="custom-control-input permission-checkbox" 
                                                       id="perm_{{ $permission->id }}" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}"
                                                       data-group="{{ $group }}">
                                                <label class="custom-control-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->display_name }}
                                                    <a href="{{ route('permissions.edit', $permission->id) }}" 
                                                       class="text-primary ml-2" 
                                                       title="تعديل"
                                                       target="_blank">
                                                        <i class="fas fa-edit fa-sm"></i>
                                                    </a>
                                                    @if($permission->description)
                                                        <br><small class="text-muted">{{ $permission->description }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ الصلاحيات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Permissions Management Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">جميع الصلاحيات المتاحة</h6>
            <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> إضافة صلاحية
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="permissionsTable">
                    <thead class="thead-light">
                        <tr>
                            <th>الاسم التقني</th>
                            <th>الاسم المعروض</th>
                            <th>الوصف</th>
                            <th>المجموعة</th>
                            <th>المسار</th>
                            <th>المناصب المخصصة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedPermissions->flatten() as $permission)
                            <tr>
                                <td><code>{{ $permission->name }}</code></td>
                                <td>{{ $permission->display_name }}</td>
                                <td>{{ $permission->description ?: '-' }}</td>
                                <td>
                                    @php
                                        $groupNames = [
                                            'dashboard' => 'لوحة التحكم',
                                            'positions' => 'المناصب والصلاحيات',
                                            'statistics' => 'الإحصائيات',
                                            'strategy' => 'الأهداف الإستراتيجية',
                                            'team' => 'إدارة الفريق',
                                            'tasks' => 'المهام',
                                            'tickets' => 'التذاكر',
                                            'calendar' => 'التقويم',
                                            'profile' => 'الملف الشخصي',
                                            'reports' => 'التقارير',
                                            'settings' => 'الإعدادات',
                                            'general' => 'عام'
                                        ];
                                    @endphp
                                    <span class="badge badge-primary">{{ $groupNames[$permission->group] ?? $permission->group }}</span>
                                </td>
                                <td>{{ $permission->route ?: '-' }}</td>
                                <td>
                                    @if($permission->employeePositions->count() > 0)
                                        <span class="badge badge-success">{{ $permission->employeePositions->count() }} منصب</span>
                                    @else
                                        <span class="badge badge-secondary">غير مخصصة</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('permissions.edit', $permission->id) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger delete-permission" 
                                            data-id="{{ $permission->id }}"
                                            data-name="{{ $permission->display_name }}"
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#permissionsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json"
        },
        "pageLength": 25,
        "order": [[3, "asc"], [1, "asc"]] // Sort by group, then by display name
    });

    // Group checkbox functionality
    $('.group-checkbox').on('change', function() {
        var group = $(this).data('group');
        var isChecked = $(this).is(':checked');
        
        $('input[data-group="' + group + '"].permission-checkbox').prop('checked', isChecked);
        updateSelectAllButtonState();
    });

    // Update group checkbox when individual permissions change
    $('.permission-checkbox').on('change', function() {
        var group = $(this).data('group');
        var groupCheckboxes = $('input[data-group="' + group + '"].permission-checkbox');
        var checkedCount = groupCheckboxes.filter(':checked').length;
        var totalCount = groupCheckboxes.length;
        
        var groupCheckbox = $('.group-checkbox[data-group="' + group + '"]');
        
        if (checkedCount === 0) {
            groupCheckbox.prop('indeterminate', false).prop('checked', false);
        } else if (checkedCount === totalCount) {
            groupCheckbox.prop('indeterminate', false).prop('checked', true);
        } else {
            groupCheckbox.prop('indeterminate', true);
        }
        
        updateSelectAllButtonState();
    });

    // Select all permissions
    $('#selectAllPermissions').on('click', function() {
        $('.permission-checkbox').prop('checked', true);
        $('.group-checkbox').prop('checked', true).prop('indeterminate', false);
        updateSelectAllButtonState();
        
        // Show confirmation
        $(this).html('<i class="fas fa-check"></i> تم تحديد الكل').removeClass('btn-success').addClass('btn-info');
        setTimeout(function() {
            $('#selectAllPermissions').html('<i class="fas fa-check-square"></i> تحديد جميع الصلاحيات').removeClass('btn-info').addClass('btn-success');
        }, 1500);
    });

    // Unselect all permissions
    $('#unselectAllPermissions').on('click', function() {
        $('.permission-checkbox').prop('checked', false);
        $('.group-checkbox').prop('checked', false).prop('indeterminate', false);
        updateSelectAllButtonState();
        
        // Show confirmation
        $(this).html('<i class="fas fa-check"></i> تم إلغاء التحديد').removeClass('btn-warning').addClass('btn-info');
        setTimeout(function() {
            $('#unselectAllPermissions').html('<i class="fas fa-square"></i> إلغاء تحديد الكل').removeClass('btn-info').addClass('btn-warning');
        }, 1500);
    });

    // Function to update select all button state
    function updateSelectAllButtonState() {
        var totalPermissions = $('.permission-checkbox').length;
        var checkedPermissions = $('.permission-checkbox:checked').length;
        
        // Update counter
        $('#permissionCounter').text(`${checkedPermissions} من ${totalPermissions} محددة`);
        
        if (checkedPermissions === 0) {
            $('#selectAllPermissions').prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
            $('#unselectAllPermissions').prop('disabled', true).removeClass('btn-warning').addClass('btn-secondary');
        } else if (checkedPermissions === totalPermissions) {
            $('#selectAllPermissions').prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
            $('#unselectAllPermissions').prop('disabled', false).removeClass('btn-secondary').addClass('btn-warning');
        } else {
            $('#selectAllPermissions').prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
            $('#unselectAllPermissions').prop('disabled', false).removeClass('btn-secondary').addClass('btn-warning');
        }
    }

    // When employee position is selected
    $('#employeePositionSelect').on('change', function() {
        var positionId = $(this).val();
        
        if (!positionId) {
            $('#permissionsContainer').hide();
            // Reset button states
            $('#selectAllPermissions').prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
            $('#unselectAllPermissions').prop('disabled', true).removeClass('btn-warning').addClass('btn-secondary');
            return;
        }

        $('#selectedPositionId').val(positionId);
        
        // Load permissions for this position
        $.ajax({
            url: '/permissions/' + positionId,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Uncheck all first
                    $('.permission-checkbox').prop('checked', false);
                    $('.group-checkbox').prop('checked', false).prop('indeterminate', false);
                    
                    // Check the permissions this position has
                    response.permissions.forEach(function(permId) {
                        $('#perm_' + permId).prop('checked', true);
                    });
                    
                    // Update group checkboxes
                    $('.group-checkbox').each(function() {
                        var group = $(this).data('group');
                        var groupCheckboxes = $('input[data-group="' + group + '"].permission-checkbox');
                        var checkedCount = groupCheckboxes.filter(':checked').length;
                        var totalCount = groupCheckboxes.length;
                        
                        if (checkedCount === 0) {
                            $(this).prop('indeterminate', false).prop('checked', false);
                        } else if (checkedCount === totalCount) {
                            $(this).prop('indeterminate', false).prop('checked', true);
                        } else {
                            $(this).prop('indeterminate', true);
                        }
                    });
                    
                    // Update select all button state
                    updateSelectAllButtonState();
                    
                    $('#permissionsContainer').show();
                }
            },
            error: function() {
                alert('حدث خطأ أثناء تحميل الصلاحيات');
            }
        });
    });

    // Save permissions
    $('#permissionsForm').on('submit', function(e) {
        e.preventDefault();
        
        var positionId = $('#selectedPositionId').val();
        var formData = $(this).serialize();
        
        $.ajax({
            url: '/permissions/' + positionId,
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
            error: function() {
                Swal.fire({
                    title: 'خطأ!',
                    text: 'حدث خطأ أثناء حفظ الصلاحيات',
                    icon: 'error',
                    confirmButtonText: 'موافق'
                });
            }
        });
    });

    // Delete permission
    $('.delete-permission').on('click', function() {
        var permissionId = $(this).data('id');
        var permissionName = $(this).data('name');
        
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'سيتم حذف الصلاحية "' + permissionName + '" نهائياً!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/permissions/' + permissionId,
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
                                location.reload();
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
