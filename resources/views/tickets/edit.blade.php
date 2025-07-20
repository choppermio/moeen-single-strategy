@extends('layouts.admin')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
// // $k = \App\Models\Todo::find(10)->moashermkmfs;
// dd($k);

@endphp

@section('content')
<div class="container">
    <x-page-heading :title="'إنشاء تذكرة'"  />
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
            align-items: center;
            margin-right: 10px;
            position: relative;
            border: 1px solid #ccc;
            padding: 5px;
        }
        .thumbnail img, .thumbnail .file-icon {
            height: 100px; /* Consistent height for all thumbnails */
        }
        .thumbnail .close {
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
            background-color: red;
            color: white;
            padding: 2px 5px;
        }
        .filename {
            margin-left: 10px;
            font-size: 0.9em;
            color: #666;
        }
    </style>


<form method="POST" action="{{ route('tickets.update', $ticket->id) }}" id="fileUploadForm">
    @csrf
   
    
    <label>إسم التذكرة</label>
    <input type="text" class="form-control" name="name" value="{{ $ticket->name }}" required/>
    <input type="hidden" class="form-control" name="ticket_id" value="{{ $ticket->id }}" required/>
    <br />
    
    {{-- <label>التذكرة إلى</label>
    @php
    $users = App\Models\User::all();
    @endphp
   

   @php
        $picked_task = \App\Models\Task::where('id',$ticket->id)->first();
        $tasks = \App\Models\Task::where('user_id',$ticket->to_id)->get();
        $subtask = \App\Models\Subtask::where('ticket_id',$ticket->id)->first();
        // dd($subtask);
    // dd($subtask->count());
        
    @endphp


    <select name="to_id" id="to_id" class="form-control" required>
        @foreach ($employeePositions as $employee_position)
        <option value="{{ $employee_position->id }}" {{ $ticket->to_id == $subtask->user_id ? 'selected' : '' }}>
            {{ $employee_position->name }}
        </option>
        @endforeach
    </select>
    <hr />

    <h5>اختر الإجراء او اتركه بدون اجراء لتمكين الموظف من تحديد الاجراء المناسب</h5>
    
    
    <div id="tasks-container">
       
        <select name="task_id" id="task_id" class="form-control" required>
            <option value="0">بدون اختيار</option>
            @foreach ($tasks as $task)
            @if(isset($subtask))
            @php
            // dd('222');
                // dd($subtask->parent_id);
                $task_picked = \App\Models\Task::where('id',$subtask->parent_id)->first();
            @endphp

            <option value="{{ $task_picked->id }}">{{ $task_picked->name }} 
                @php
                    $mubadara_name = \App\Models\Mubadara::where('id',$task_picked->parent_id)->first()->name;
                    @endphp
        
                ( {{$mubadara_name }})
                </option>

            @endif
                <option value="{{ $task->id }}">{{ $task->name }} 
                @php
                    $mubadara_name = \App\Models\Mubadara::where('id',$task->parent_id)->first()->name;
                    @endphp
        
                ( {{$mubadara_name }})
                </option>
            @endforeach
        </select>
        
    </div> --}}
    <br />
    
    <label>ملاحظة إضافية</label>
    <textarea name="note" class="form-control" required>{{ $ticket->note }}</textarea>
    <br />
    
    <div class="">
    <label>وقت الإنتهاء المتوقع</label>
    <input type="datetime-local" class="form-control" name="duetime" id="duetime" value="{{ \Carbon\Carbon::parse($ticket->due_time)->format('Y-m-d\TH:i') }}" required />
</div>

<div id="preview"></div>
<input type="file" name="files[]" multiple>

    <input type="submit" class="btn btn-primary mt-3" value="تحديث التذكرة" />
    
</form>
<div id="snackbar">تم التحديث بنجاح..</div>

</div>

<div id="snackbar">تمت الإضافة بنجاح..</div>

</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  
  
<script>
    function myFunction() {
      var x = document.getElementById("snackbar");
      x.className = "show";
      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
    </script>
  <script>
    $(document).ready(function() {
        $('#to_id').change(function() {
            var userId = $(this).val(); // Get selected user ID
            
    
            $.ajax({
                url: '{{ env("APP_URL", "") }}get-tasks', // Laravel route
                type: 'GET',
                data: { user_id: userId },
                success: function(response) {
                    console.log(response)
                    $('#tasks-container').html(response); // Update tasks container with response
                }
            });
        });
    });
    </script>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const input = document.getElementById('duetime');
        const form = document.getElementById('myForm');
        const now = new Date();
        now.setHours(now.getHours() + 1); // Add one hour to the current time
    
        // Format the datetime string for the input min attribute
        let minDateTime = now.toISOString().slice(0, 16); // Convert to YYYY-MM-DDTHH:MM format
        input.min = minDateTime;
    
        form.addEventListener('submit', function(e) {
            const selectedDateTime = new Date(input.value);
            if(selectedDateTime < now) {
                e.preventDefault(); // Prevent form submission
                alert('الرجاء اختيار تاريخ ووقت يكون على الأقل بعد ساعة من الآن.');
            }
        });
    });
    </script>
     <script>
        var fileArray = [];

        $(document).ready(function() {
            $('input[type="file"]').on('change', function(e) {
                var files = e.target.files;
                for (let i = 0; i < files.length; i++) {
                    fileArray.push(files[i]);
                    if (/^image\//i.test(files[i].type)) {
                        displayThumbnail(files[i], fileArray.length - 1);
                    } else {
                        displayFileIcon(files[i], fileArray.length - 1);
                    }
                }
            });

            $('#fileUploadForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData();
                fileArray.forEach(function(file) {
                    if (file !== null) {
                        formData.append('files[]', file);
                    }
                });

                //formData append all the input feilds except input files
                var other_data = $('#fileUploadForm').serializeArray();
                $.each(other_data, function(key, input) {
                    formData.append(input.name, input.value);
                });
                
                console.log(formData);

                


                $.ajax({
                    url: '{{ url("/upload-files-update/subtask/51") }}',
                    type: 'POST',
                    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Include CSRF token in the header
    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        myFunction()
                        document.getElementById('fileUploadForm').reset();
                        removeAllThumbs()
                        console.log('Files uploaded successfully:', response);
                    },
                    error: function(xhr, status, error) {
                        myFunction()
                        console.error('Upload failed:', error);
                    }
                });

                // var fileArray=[];
            });
        });
        function removeAllThumbs() {
             fileArray=[];
            $('#preview').html('')
        }
        function displayThumbnail(file, index) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var html = `<div class="thumbnail" data-index="${index}">
                                <img src="${e.target.result}" alt="File">
                                <div class="filename">${escapeHTML(file.name)}</div>
                                <span class="close" onclick="removeThumbnail(${index})">X</span>
                            </div>`;
                $('#preview').append(html);
            };
            reader.readAsDataURL(file);
        }

        function displayFileIcon(file, index) {
            var html = `<div class="thumbnail" data-index="${index}">
                            <div class="file-icon">📄</div>
                            <div class="filename">${escapeHTML(file.name)}</div>
                            <span class="close" onclick="removeThumbnail(${index})">X</span>
                        </div>`;
            $('#preview').append(html);
        }

        function removeThumbnail(index) {
            // Splice the fileArray at the index, removing 1 item
            fileArray.splice(index, 1);

            // Remove the thumbnail from the DOM
            $(`.thumbnail[data-index="${index}"]`).remove();

            // Log the updated length of the fileArray
            console.log(fileArray.length);

            // Adjust the indexes in the DOM for each remaining thumbnail
            $('.thumbnail').each(function(i, elem) {
                $(elem).attr('data-index', i); // Reset index to match the array after removal
            });

            // If the fileArray is empty, clear the file input field
            if (fileArray.length === 0) {
                $('input[type="file"]').val('');
            }
        }


        function escapeHTML(text) {
            return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }
    </script>
@endsection
