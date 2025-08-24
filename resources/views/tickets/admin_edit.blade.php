@extends('layouts.admin')

@section('content')
<div class="container-fluid">    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل التذكرة #{{ $ticket->id }}</h1>
        <a href="{{ route('tickets.admin.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة للقائمة
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> يرجى تصحيح الأخطاء التالية:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">تعديل بيانات التذكرة</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.admin.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                          <div class="form-group">
                            <label for="name">اسم التذكرة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $ticket->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="due_time">تاريخ الاستحقاق <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('due_time') is-invalid @enderror" 
                                   id="due_time" name="due_time" 
                                   value="{{ old('due_time', $ticket->due_time ? \Carbon\Carbon::parse($ticket->due_time)->format('Y-m-d\TH:i') : '') }}" 
                                   required>
                            @error('due_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="note">ملاحظات</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" name="note" rows="4">{{ old('note', $ticket->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        <div class="form-group">
                            <label for="files">إضافة ملفات جديدة</label>
                            <input type="file" class="form-control-file @error('files') is-invalid @enderror" 
                                   id="files" name="files[]" multiple 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                            <small class="form-text text-muted">أنواع الملفات المسموحة: PDF, Word, Excel, PowerPoint, الصور. يمكنك اختيار ملفات متعددة (الحد الأقصى 10 ميجابايت لكل ملف).</small>
                            @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('files.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Files Section -->
                        @if($ticket->images && $ticket->images->count() > 0)
                        <div class="form-group">
                            <label>الملفات المرفقة الحالية ({{ $ticket->images->count() }} ملف)</label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> يمكنك تحميل الملفات الحالية أو حذفها. الملفات الجديدة ستضاف للملفات الموجودة.
                            </div>
                            <div class="row">
                                @foreach($ticket->images as $index => $image)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-primary">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $extension = pathinfo($image->filename, PATHINFO_EXTENSION);
                                                            $iconClass = 'fa-file';
                                                            $iconColor = 'text-secondary';
                                                            switch(strtolower($extension)) {
                                                                case 'pdf': $iconClass = 'fa-file-pdf'; $iconColor = 'text-danger'; break;
                                                                case 'doc':
                                                                case 'docx': $iconClass = 'fa-file-word'; $iconColor = 'text-primary'; break;
                                                                case 'xls':
                                                                case 'xlsx': $iconClass = 'fa-file-excel'; $iconColor = 'text-success'; break;
                                                                case 'ppt':
                                                                case 'pptx': $iconClass = 'fa-file-powerpoint'; $iconColor = 'text-warning'; break;
                                                                case 'jpg':
                                                                case 'jpeg':
                                                                case 'png':
                                                                case 'gif': $iconClass = 'fa-file-image'; $iconColor = 'text-info'; break;
                                                            }
                                                        @endphp
                                                        <i class="fas {{ $iconClass }} {{ $iconColor }} fa-lg mr-2"></i>
                                                        <div>
                                                            <small class="font-weight-bold text-truncate d-block" style="max-width: 150px;" title="{{ $image->filename }}">
                                                                {{ Str::limit($image->filename, 20) }}
                                                            </small>
                                                            <small class="text-muted">{{ strtoupper($extension) }} - {{ round(\Storage::size($image->filepath) / 1024, 1) }} KB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-2">
                                                    <a href="{{ asset('storage/' . str_replace('public/', '', $image->filepath)) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="تحميل الملف">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger ml-1" 
                                                            onclick="removeFile({{ $image->id }})"
                                                            title="حذف الملف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> لا توجد ملفات مرفقة حالياً. يمكنك إضافة ملفات جديدة أعلاه.
                            </div>
                        </div>
                        @endif

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> حفظ التغييرات
                            </button>
                            <a href="{{ route('tickets.admin.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Ticket Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات التذكرة</h6>
                </div>
                <div class="card-body">
                    <p><strong>رقم التذكرة:</strong> {{ $ticket->id }}</p>
                    <p><strong>تاريخ الإنشاء:</strong> {{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : 'غير محدد' }}</p>                    <p><strong>المرسل:</strong> 
                        @if($ticket->fromEmployeePosition && $ticket->fromEmployeePosition->user)
                            {{ $ticket->fromEmployeePosition->user->name }}
                            <br><small class="text-muted">{{ $ticket->fromEmployeePosition->name }}</small>
                        @else
                            <span class="text-muted">غير محدد</span>
                        @endif
                    </p>
                    <p><strong>مُسند إلى:</strong> 
                        @if($ticket->toEmployeePosition && $ticket->toEmployeePosition->user)
                            {{ $ticket->toEmployeePosition->user->name }}
                            <br><small class="text-muted">{{ $ticket->toEmployeePosition->name }}</small>
                        @else
                            <span class="text-muted">غير محدد</span>
                        @endif
                    </p>
                    <p><strong>الحالة الحالية:</strong> 
                        @switch($ticket->status)
                            @case('pending')
                                <span class="badge badge-warning">معلقة</span>
                                @break
                            @case('approved')
                                <span class="badge badge-success">معتمدة</span>
                                @break
                            @case('rejected')
                                <span class="badge badge-danger">مرفوضة</span>
                                @break
                            @case('completed')
                                <span class="badge badge-primary">مكتملة</span>
                                @break
                            @case('transfered')
                                <span class="badge badge-info">محولة</span>
                                @break
                            @default
                                <span class="badge badge-secondary">{{ $ticket->status }}</span>
                        @endswitch
                    </p>
                </div>
            </div>

            <!-- Subtasks Info Card -->
            @if($ticket->subtasks->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">المهام الفرعية المرتبطة</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        تحتوي هذه التذكرة على {{ $ticket->subtasks->count() }} مهمة فرعية. 
                        عند تحديث التذكرة، سيتم تحديث المهام الفرعية المرتبطة تلقائياً.
                    </div>
                    @foreach($ticket->subtasks as $subtask)
                    <div class="mb-2">
                        <strong>المهمة #{{ $subtask->id }}:</strong> {{ $subtask->name }}
                        <br><small class="text-muted">التقدم: {{ $subtask->percentage }}%</small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif        </div>
    </div>
</div>

<script>
// Function to remove a file
function removeFile(imageId) {
    if (confirm('هل أنت متأكد من حذف هذا الملف؟ لا يمكن التراجع عن هذا الإجراء.')) {
        // Show loading indicator
        const button = event.target.closest('button');
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("tickets.admin.removeFile", $ticket->id) }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Add image ID
        const imageIdField = document.createElement('input');
        imageIdField.type = 'hidden';
        imageIdField.name = 'image_id';
        imageIdField.value = imageId;
        form.appendChild(imageIdField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// File input change handler to show selected files
document.getElementById('files').addEventListener('change', function(e) {
    const files = e.target.files;
    if (files.length > 0) {
        let fileNames = [];
        for (let i = 0; i < files.length; i++) {
            fileNames.push(files[i].name);
        }
        
        // Show selected files count
        const helpText = e.target.nextElementSibling;
        helpText.innerHTML = `تم اختيار ${files.length} ملف: ${fileNames.join(', ')}`;
        helpText.className = 'form-text text-success';
    }
});

// Form submission handler to show loading state
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds in case of errors
    setTimeout(function() {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});
</script>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.card:hover {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.btn-outline-primary:hover,
.btn-outline-danger:hover {
    transform: translateY(-1px);
    transition: all 0.2s;
}

.file-upload-area {
    border: 2px dashed #d1d3e2;
    border-radius: 0.375rem;
    padding: 1rem;
    text-align: center;
    transition: border-color 0.2s;
}

.file-upload-area:hover {
    border-color: #4e73df;
}

.file-upload-area.dragover {
    border-color: #4e73df;
    background-color: #f8f9fc;
}

.text-truncate {
    max-width: 150px;
}
</style>
@endsection
