@extends('layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#to_id').select2({
            placeholder: "اختر أحد الخيارات",
            width: '100%', // Ensures the dropdown fits properly
            language: "ar" // Sets the language to Arabic if needed
        });
    });
</script>

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
        
        /* Loading Screen Styles */
        #loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loading-content {
            text-align: center;
            color: white;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <form method="POST" action="{{ route('tickets.store') }}" id="fileUploadForm">
    @csrf
    <label>إسم التذكرة</label>
    <div id="name-container">
        <div class="name-input-group">
            <input type="text" class="form-control" name="name[]" required     style="width: 93%;
                  float: right;"/>
            <button type="button" class="btn btn-success btn-sm add-name " style="float:left;">إضافة</button>
        </div>
    </div>
    <br />

    <label>التذكرة إلى</label>
    @php
        $users = App\Models\User::all();
    @endphp
    
    <style>
    #to_id {
        height: auto; /* Adjust height for better visibility of filtered options */
        max-height: 200px;
        overflow-y: auto;
    }
</style>
    <div id="searchable-dropdown">
    <input type="text" id="search-input" placeholder="ابحث هنا..." style="width: 100%; margin-bottom: 10px; padding: 8px;">
      <select name="to_id[]" id="to_id" class="form-control" multiple required>
        @php
            $current_user_position = current_user_position()->id;
        @endphp

        @if(isset($_GET['myself']))
        
            <option value="{{ current_user_position()->id }}" @if(isset($_GET['myself']) && current_user_position()->id == $current_user_position) selected @endif>
                {{ current_user_position()->name }} - 
                @php
                    echo \App\Models\User::where('id', current_user_position()->user_id)->first()->name;
                @endphp
            </option>
        @else 
            @foreach ($employeePositions as $employee_position)
                <option value="{{ $employee_position->id }}" @if(isset($_GET['myself']) && $employee_position->id == $current_user_position) selected @endif>
                    {{ $employee_position->name }} - 
                    @php
                        echo \App\Models\User::where('id', $employee_position->user_id)->first()->name;
                    @endphp
                </option>
            @endforeach
        @endif

    </select>
    </div>
    
    <script>
    document.getElementById('search-input').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const select = document.getElementById('to_id');
        const options = select.options;

        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].textContent.toLowerCase();
            options[i].style.display = optionText.includes(filter) ? '' : 'none';
        }
    });
</script>


    <hr />

    @if(isset($_GET['myself']))
        <input type="hidden" name="myself" value="1" />
    @else
        <input type="hidden" name="myself" value="0" />
    @endif

    <h5>اختر الإجراء او اتركه بدون اجراء لتمكين الموظف من تحديد الاجراء المناسب</h5>
    <div id="tasks-container">
        <!-- Tasks will be loaded here -->
    </div>
    <br />

    <label>ملاحظة إضافية</label>
    <textarea name="note" class="form-control" ></textarea>
    <br />

    <div>
        <label>وقت الإنتهاء المتوقع</label>
        <input type="datetime-local" class="form-control" name="duetime" id="duetime" required />
    </div>
    <br />

    <div id="preview"></div>
    <input type="file" name="files[]" multiple>
    <br />    <input type="submit" class="btn btn-primary mt-3" name="submito" value="إنشاء التذكرة" />
</form>

<!-- Loading Screen -->
<div id="loading-screen">
    <div class="loading-content">
        <div class="spinner"></div>
        <h4>جاري رفع الملفات وإنشاء التذكرة...</h4>
        <p>يرجى الانتظار</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('name-container');

        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('add-name')) {
                const newInputGroup = document.createElement('div');
                newInputGroup.classList.add('name-input-group', 'mt-2');
                newInputGroup.innerHTML = `
                    <input type="text" class="form-control" name="name[]"  style="width: 93%; margin-top:10px;
                  float: right;" required />
                    <button type="button" class="btn btn-danger btn-sm remove-name" style="float:left;margin-top:10px;">إزالة</button>
                `;
                container.appendChild(newInputGroup);
            }

            if (e.target.classList.contains('remove-name')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>

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
        
        var userId = $('#to_id').val(); // Get selected user ID
        if (new URLSearchParams(window.location.search).has('myself')) {
            $.ajax({
                url: '{{ env("APP_URL", "") }}get-tasks', // Laravel route
                type: 'GET',
                data: { user_id: userId },
                success: function(response) {
                    console.log(response)
                    $('#tasks-container').html(response); // Update tasks container with response
                    $('#tasks-container select option:first').remove();
                },error: function(response) {
                    console.log(response)
                }
            });

        }

    // Run the check on initial load
 

    // Attach change event to monitor changes in the select menu
    

        $('#to_id').change(function() {

            var selectedOptions = $('#to_id option:selected');
            // alert('aaa')

console.log(selectedOptions);
            if (selectedOptions.length > 1) {

            $('#task_id').val(0);
            $('#task_id').prop('disabled', true);
        } else {
            

            var userId = $(this).val(); // Get selected user ID
            console.log(userId);
    
            $.ajax({
                url: '{{ env("APP_URL", "") }}get-tasks', // Laravel route
                type: 'GET',
                data: { user_id: userId },
                success: function(response) {
                    console.log(response)
                    $('#tasks-container').html(response); // Update tasks container with response
                }
            });
        }
       
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
            });            $('#fileUploadForm').on('submit', function(e) {
                e.preventDefault();
                
                // Show loading screen
                $('#loading-screen').css('display', 'flex');
                
                var formData = new FormData();
                fileArray.forEach(function(file) {
                    if (file !== null) {
                        formData.append('files[]', file);
                    }
                });

                //formData append all the input feilds except input files
                var other_data = $('#fileUploadForm').serializeArray();
                $.each(other_data, function(key, input) {
                    if(input.name != 'to_id[]'){
                        console.log(input.name);
                    formData.append(input.name, input.value);
                 }
                });

                
                console.log(formData);

                var selectedValues = $('#to_id').val().join(',');

// Append the comma-separated string to formData
formData.append('to_id', selectedValues);


                $.ajax({
                    url: '{{ url("/upload-files/subtask/51") }}',
                    type: 'POST',
                    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Include CSRF token in the header
    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Hide loading screen
                        $('#loading-screen').hide();
                        
                        myFunction()
                        
                        // Clear form fields on success
                        document.getElementById('fileUploadForm').reset();
                        $('#to_id').val(null).trigger('change'); // Reset Select2
                        $('#tasks-container').html(''); // Clear tasks container
                        
                        if (new URLSearchParams(window.location.search).has('myself')) {
                            var form = document.getElementById('fileUploadForm');
                            var elements = form.elements;
                            for (var i = 0, len = elements.length; i < len; ++i) {
                                if (elements[i].name !== "to_id[]" || elements[i].name=="submito") {
                                    elements[i].value = "";
                                }
                            }
                        }
                        removeAllThumbs()
                        console.log('Files uploaded successfully:', response);
                        setTimeout(() => {
                            //reload the page
                            $('input[name="submito"]').val('إنشاء التذكرة');
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        // Hide loading screen on error
                        $('#loading-screen').hide();
                        
                        console.error('Upload failed:', error);
                        alert('حدث خطأ أثناء رفع الملفات. يرجى المحاولة مرة أخرى.');
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
