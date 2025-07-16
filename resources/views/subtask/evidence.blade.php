@extends('layouts.admin')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp
<style>
    #snackbar {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
    }
    
    #snackbar.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    
    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;} 
      to {bottom: 30px; opacity: 1;}
    }
    
    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    
    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;} 
      to {bottom: 0; opacity: 0;}
    }
    
    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
    </style>
<style>
    #preview {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .thumbnail {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 10px;
        margin-bottom: 15px;
        position: relative;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 8px;
        background-color: #f9f9f9;
        width: 200px;
    }
    .thumbnail img, .thumbnail .file-icon {
        height: 80px;
        margin-bottom: 8px;
    }
    .thumbnail .close {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        background-color: red;
        color: white;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 12px;
    }
    .filename {
        font-size: 0.85em;
        color: #333;
        text-align: center;
        margin-bottom: 8px;
        word-break: break-word;
    }
    .note-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.85em;
        resize: vertical;
        min-height: 50px;
        margin-top: 8px;
        font-family: 'Cairo', sans-serif;
        direction: rtl;
        text-align: right;
    }
    .note-input:focus {
        border-color: #2797b6;
        outline: none;
        box-shadow: 0 0 5px rgba(39, 151, 182, 0.3);
    }
    .note-input::placeholder {
        color: #999;
        font-style: italic;
    }
    #loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 1000;
}

.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@section('content')
<div id="snackbar">تم رفع الملفات بنجاح!</div>
<div id="loading-screen" class="loading-screen" style="display: none;">
    <div class="loader"></div>
    <p>الرجاء الإنتظار جاري رفع الملفات...</p>
</div>
<div class="container">
    
<!-- bootstrap cdn-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <h3>المرفقات</h3>
    <div class="alert alert-info" role="alert">
        <strong>تعليمات:</strong>
        <ul class="mb-0 mt-2">
            <li>أقصى حجم للملف الواحد 10 ميجا</li>
            <li>يمكنك إضافة ملاحظة لكل ملف قبل الرفع</li>
            <li>الملاحظات اختيارية ولكن يُنصح بإضافتها لتوضيح محتوى الملف</li>
        </ul>
    </div>
    <form method="post" action="{{ route('subtask.attachment') }}" enctype="multipart/form-data" id="fileUploadForm">
        @csrf
        <input type="hidden" name="subtask" value="{{ $subtaskid }}"/>
        
        <input type="file" multiple 
        {{-- name="image" --}}
        name="files[]"
        required />
        <div id="preview"></div>
        <input type="submit" value="إرسال" />
    </div>
    </form>

    
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>الملف</th>
                <th>الملاحظة</th>
                <th>حذف</th>
            </tr>
        </thead>
        <tbody>
            @php
              
            @endphp
            @foreach ($imagess as $image)
            <tr>
             <td>
                 @php
                //  $url = Storage::url('7');
                //  $path = storage_path('app/public/7/New-Project.png');

                // //  dd($path);

                $imageurl = $image->getUrl();
$imageurl = str_replace('//uploads', '/uploads', $imageurl);
$imageurl = ltrim($imageurl, '/');

                
// using ltrim to avoid double slashes, you're welcome

// and now, the blade template
@endphp
<a href="{{ $imageurl }}" target="_blank">{{ $image->name }}</a>
             </td>
             <td>
                 <div style="max-width: 200px; word-wrap: break-word;">
                     {{ $image->getCustomProperty('note') ?? 'لا توجد ملاحظة' }}
                 </div>
             </td>
                <td>
                    <form action="{{ route('subtask.attachment.delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $image->id }}" />
                        <input type="hidden" name="subtask" value="{{ $subtaskid }}" />
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
  <script>
    var fileArray = [];
    var fileNotes = []; // Array to store notes for each file

    $(document).ready(function() {
        $('input[type="file"]').on('change', function(e) {
            var files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                fileArray.push(files[i]);
                fileNotes.push(''); // Initialize with empty note
                if (/^image\//i.test(files[i].type)) {
                    displayThumbnail(files[i], fileArray.length - 1);
                } else {
                    displayFileIcon(files[i], fileArray.length - 1);
                }
            }
        });

        $('#fileUploadForm').on('submit', function(e) {
            document.getElementById('loading-screen').style.display = 'flex';

            e.preventDefault();
            var formData = new FormData();
            
            // Add files and their corresponding notes
            fileArray.forEach(function(file, index) {
                if (file !== null) {
                    formData.append('files[]', file);
                    formData.append('notes[]', fileNotes[index] || '');
                }
            });

            //formData append all the input feilds except input files
            var other_data = $('#fileUploadForm').serializeArray();
            $.each(other_data, function(key, input) {
               
                formData.append(input.name, input.value);
             
            });

            
            console.log(formData);




            $.ajax({
                url: '{{ route("subtask.attachment") }}',
                type: 'POST',
                headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Include CSRF token in the header
},
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                   // alert('تم رفع الملفات:', response);
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                    myFunction()
                    document.getElementById('fileUploadForm').reset();
                    removeAllThumbs()
                    document.getElementById('loading-screen').style.display = 'none';

                },
                error: function(xhr, status, error) {
                    console.error('Upload failed:', error);
                    document.getElementById('loading-screen').style.display = 'none';

                }
            });

            // var fileArray=[];
        });
    });
    
    // Function to update note when user types
    function updateNote(index, note) {
        fileNotes[index] = note;
    }
    
    function removeAllThumbs() {
         fileArray=[];
         fileNotes=[];
        $('#preview').html('')
    }
    function displayThumbnail(file, index) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var html = `<div class="thumbnail" data-index="${index}">
                            <span class="close" onclick="removeThumbnail(${index})">×</span>
                            <img src="${e.target.result}" alt="File">
                            <div class="filename">${escapeHTML(file.name)}</div>
                            <textarea class="note-input" placeholder="أضف ملاحظة للملف..." 
                                onchange="updateNote(${index}, this.value)" 
                                onkeyup="updateNote(${index}, this.value)"></textarea>
                        </div>`;
            $('#preview').append(html);
        };
        reader.readAsDataURL(file);
    }

    function displayFileIcon(file, index) {
        var html = `<div class="thumbnail" data-index="${index}">
                        <span class="close" onclick="removeThumbnail(${index})">×</span>
                        <div class="file-icon">📄</div>
                        <div class="filename">${escapeHTML(file.name)}</div>
                        <textarea class="note-input" placeholder="أضف ملاحظة للملف..." 
                            onchange="updateNote(${index}, this.value)" 
                            onkeyup="updateNote(${index}, this.value)"></textarea>
                    </div>`;
        $('#preview').append(html);
    }

    function removeThumbnail(index) {
        // Splice the fileArray at the index, removing 1 item
        fileArray.splice(index, 1);
        fileNotes.splice(index, 1);

        // Remove the thumbnail from the DOM
        $(`.thumbnail[data-index="${index}"]`).remove();

        // Log the updated length of the fileArray
        console.log(fileArray.length);

        // Adjust the indexes in the DOM for each remaining thumbnail
        $('.thumbnail').each(function(i, elem) {
            $(elem).attr('data-index', i); // Reset index to match the array after removal
            // Update the onclick handlers for the close button and note inputs
            $(elem).find('.close').attr('onclick', `removeThumbnail(${i})`);
            $(elem).find('.note-input').attr('onchange', `updateNote(${i}, this.value)`);
            $(elem).find('.note-input').attr('onkeyup', `updateNote(${i}, this.value)`);
        });

        // If the fileArray is empty, clear the file input field
        if (fileArray.length === 0) {
            $('input[type="file"]').val('');
        }
    }


    function escapeHTML(text) {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }
    
    function myFunction() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>

  @endsection