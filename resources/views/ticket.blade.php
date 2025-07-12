
@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


<style>body{direction:rtl;}</style>
<style>
    .text-input[disabled] {
        background-color: #f1f1f1;
    }
</style>

<div class="container">

  

<form action="{{ route('tickets.store') }}" method="post">
    @csrf
    <div class="form-group">

        <label>
            <input type="radio" name="option" value="select_input" checked> تحويل التذكرة إلى مهمة من مهام موظف
        </label>
        |
        <label>
            <input type="radio" name="option" value="text_input" > أنشئ تذكرة وأسندها لموظف
        </label>

    </div>


    <hr />
    <div class="form-group">

  <input type="text" name="name" placeholder="إسم التذكرة" class="text-input form-controller">
  <select name="t_id" class="select-input form-controller">
    <option value="">اختر التذكرة</option>
    
    @foreach ($tickets as $ticket)
      
        <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
  
    @endforeach
  </select>
</div>

<br />

<div class="form-group">
<label>اختر العضو الذي تريد اسناد المهمة له</label>
  <select name="user_id" id="user_id">
    <option value="">إختر الموظف</option>
    @foreach ($users as $user)
      
        <option value="{{ $user->id }}">{{ $user->name }}</option>
  
    @endforeach
  </select>
</div>
  <br />
  <div class="form-group" id="inwhattask">
  <label>تحت اي تاسك تريد ان يتم ادراج هذه المهمة </label>
  <label>إذا لم تختر شيئا سيتم إنشاء تكت</label>

  <select name="task" id="tasks">
    <option value="0">اختر المهمة</option>
   
  </select>
</div>
  <br />
  <br />
  <button type="submit " class="btn btn-primary">أرسل</button>
</form>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
$(document).ready(function() {

  $('#user_id').on('change', function() {
    var user_id = $(this).val();
    $.ajax({
      url: '../api/todos/' + user_id,
      success: function(data) {
        
const select = document.getElementById("tasks");
$('#tasks').html('<option value="0">Select task</option>')
data.forEach((task) => {
  const option = document.createElement("option");
  option.value = task.id;
  option.textContent = task.task;
  select.appendChild(option);
});
      }
    });
  });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textInput = document.querySelector('.text-input');
        const selectInput = document.querySelector('.select-input');
        const textInputRadio = document.querySelector('input[value="text_input"]');
        const selectInputRadio = document.querySelector('input[value="select_input"]');

        // Function to toggle the display of input fields
        function toggleInputFields() {

          const selectMenu = document.getElementById('tasks');

          $('input[name="option"]').click(function() {
            
            const selectMenu = document.getElementById('tasks');
            const selectedValue = $('input[name="option"]:checked').val();
            if(selectedValue == 'select_input'){
              selectMenu.disabled=false
            }else{
              inwhattask.style.display = 'none';
              selectMenu.disabled='disabled'
            }
            console.log(selectedValue); // This will print the selected radio button value to the browser console
        });


            if (textInputRadio.checked) {
                textInput.style.display = 'block';
                selectInput.style.display = 'none';
              } else if (selectInputRadio.checked) {
                $('#inwhattask').css('display','block');
                selectInput.style.display = 'block';
                                const selectMenu = document.getElementById('tasks');
                const selectMenuuser_id = document.getElementById('user_id');
                
                // selectMenu.disabled='disabled'


                selectMenu.value = '0';
                selectMenuuser_id.value = '0';
                textInput.style.display = 'none';
                selectInput.style.display = 'block';
            }
        }

        // Initial call to toggle input fields based on the default checked radio button
        toggleInputFields();

        // Add event listeners to the radio buttons to call the toggleInputFields function
        textInputRadio.addEventListener('change', toggleInputFields);
        selectInputRadio.addEventListener('change', toggleInputFields);
    });
</script>

@endsection