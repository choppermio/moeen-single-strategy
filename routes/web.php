<?php

use App\Models\Task;
use App\Models\Todo;
use App\Models\Subtask;
use App\Models\Mubadara;
use App\Models\Moashermkmf;
use App\Models\Hadafstrategy;
use App\Models\Moasheradastrategy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\HadafstrategyController;
use App\Http\Controllers\EmployeePositionController;
use App\Http\Controllers\TicketTransitionController;
use App\Http\Controllers\MoasheradastrategyController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\EmployeePositionRelationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Test email route to check SMTP configuration
Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email to verify SMTP configuration. If you receive this, the email setup is working correctly.', function ($message) {
            $message->to('it@qimam.org.sa')
                    ->subject('SMTP Test Email - ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully to it@qimam.org.sa',
            'config' => [
                'mail_driver' => config('mail.driver'),
                'mail_host' => config('mail.host'),
                'mail_port' => config('mail.port'),
                'mail_username' => config('mail.username'),
                'mail_encryption' => config('mail.encryption'),
                'mail_from_address' => config('mail.from.address'),
                'mail_from_name' => config('mail.from.name'),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test email',
            'error' => $e->getMessage(),
            'config' => [
                'mail_driver' => config('mail.driver'),
                'mail_host' => config('mail.host'),
                'mail_port' => config('mail.port'),
                'mail_username' => config('mail.username'),
                'mail_encryption' => config('mail.encryption'),
                'mail_from_address' => config('mail.from.address'),
                'mail_from_name' => config('mail.from.name'),
            ]
        ]);
    }
});

// Test email page - HTML interface for testing
Route::get('/test-email-page', function () {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Email Test</title>
        <meta charset="utf-8">
        <style>
            body { font-family: Arial, sans-serif; margin: 50px; }
            .container { max-width: 600px; margin: 0 auto; }
            .btn { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
            .btn:hover { background: #0056b3; }
            .result { margin-top: 20px; padding: 15px; border-radius: 5px; }
            .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
            .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>SMTP Test Email</h2>
            <p>Click the button below to send a test email to it@qimam.org.sa</p>
            <button class="btn" onclick="sendTestEmail()">Send Test Email</button>
            <div id="result"></div>
        </div>
        
        <script>
        function sendTestEmail() {
            const resultDiv = document.getElementById("result");
            resultDiv.innerHTML = "<p>Sending email...</p>";
            
            fetch("/test-email")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.innerHTML = `
                            <div class="result success">
                                <h3>Success!</h3>
                                <p>${data.message}</p>
                                <h4>Configuration:</h4>
                                <ul>
                                    <li><strong>Driver:</strong> ${data.config.mail_driver}</li>
                                    <li><strong>Host:</strong> ${data.config.mail_host}</li>
                                    <li><strong>Port:</strong> ${data.config.mail_port}</li>
                                    <li><strong>Username:</strong> ${data.config.mail_username}</li>
                                    <li><strong>Encryption:</strong> ${data.config.mail_encryption}</li>
                                    <li><strong>From Address:</strong> ${data.config.mail_from_address}</li>
                                    <li><strong>From Name:</strong> ${data.config.mail_from_name}</li>
                                </ul>
                            </div>
                        `;
                    } else {
                        resultDiv.innerHTML = `
                            <div class="result error">
                                <h3>Error!</h3>
                                <p>${data.message}</p>
                                <p><strong>Error Details:</strong> ${data.error}</p>
                                <h4>Configuration:</h4>
                                <ul>
                                    <li><strong>Driver:</strong> ${data.config.mail_driver}</li>
                                    <li><strong>Host:</strong> ${data.config.mail_host}</li>
                                    <li><strong>Port:</strong> ${data.config.mail_port}</li>
                                    <li><strong>Username:</strong> ${data.config.mail_username}</li>
                                    <li><strong>Encryption:</strong> ${data.config.mail_encryption}</li>
                                    <li><strong>From Address:</strong> ${data.config.mail_from_address}</li>
                                    <li><strong>From Name:</strong> ${data.config.mail_from_name}</li>
                                </ul>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = `
                        <div class="result error">
                            <h3>Network Error!</h3>
                            <p>Failed to send request: ${error.message}</p>
                        </div>
                    `;
                });
        }
        </script>
    </body>
    </html>
    ';
});


// Display change password form
Route::get('/change-password', [PasswordController::class, 'index'])->name('password.change');

// Process change password
Route::post('/change-password', [PasswordController::class, 'store'])->name('password.update2');

Route::group(['middleware' => 'checkUserId'], function () {
    // Routes accessible only to the user with ID 1
   
Route::post('/add-todo', [TodoController::class, 'add_todo'])->name('todo.add');

Route::get('/add-todo', [TodoController::class, 'add_todo'])->name('todo.add');
Route::resource('hadafstrategies', '\App\Http\Controllers\HadafstrategyController');
Route::get('/send-notification', [SubtaskController::class, 'sendNotification']);

//create a get route with name todesign and call the function todesign
Route::get('todesign', [HadafstrategyController::class, 'todesign'])->name('hadafstrategies.todesign');
Route::resource('hadafstrategies', '\App\Http\Controllers\HadafstrategyController');
Route::get('/hadafstrategies/{id}/edit', [HadafstrategyController::class, 'edit'])->name('hadafstrategies.edit');

Route::resource('moasheradastrategy', '\App\Http\Controllers\MoasheradastrategyController');
Route::get('/moasheradastrategy/{id}/edit', [MoasheradastrategyController::class, 'edit'])->name('Moasheradastrategy.edit');
Route::resource('moashermkmf', '\App\Http\Controllers\MoashermkmfController');
Route::resource('task', '\App\Http\Controllers\TaskController');
Route::get('/get-tasks', [TaskController::class, 'getTasksByUserId']);

Route::resource('mubadara', '\App\Http\Controllers\MubadaraController');


});





Route::group(['middleware' => 'auth'], function () {
    Route::post('removetaskmkmf',[HadafstrategyController::class, 'removeTaskMoasher'])->name('removetaskmkmf');
Route::resource('subtask', '\App\Http\Controllers\SubtaskController');
Route::get('employeepositionstop', [EmployeePositionController::class, 'top']);

Route::resource('employeepositions', '\App\Http\Controllers\EmployeePositionController');
Route::get('employeepositions/team/{id}', [EmployeePositionController::class, 'team']);

Route::post('attach-users-store/{position_id}', [EmployeePositionController::class, 'attach_users_store']);
Route::get('attach-users/{position_id}', [EmployeePositionController::class, 'attach_users']);
Route::get('employee-position-delete/{id}',[EmployeePositionRelationController::class, 'destroy']);



    //create post route for this method changeTask in subtaskcontroller
    Route::post('/change-task', [SubtaskController::class, 'changeTask'])->name('subtask.changeTask');
    Route::post('/ticket-transitions', [TicketTransitionController::class, 'store']);
    
    // Route::get('/', function () {
    //     $todos ='a';
        
        
        
    //     return view('employeepositionstop', compact('todos'));
    // });
    Route::get('/', [EmployeePositionController::class, 'top']);

    Route::get('newstrategy', function () {
        $todos ='a';
        
        
        
        return view('newstrategy', compact('todos'));
    });
    Route::resource('tickets', '\App\Http\Controllers\TicketController');

Route::get('/ticketsshow/{id}', [TicketController::class, 'showwithmessages'])->name('tickets.showwithmessages');
Route::post('/tickets/{id}/messages', [TicketController::class, 'storeMessage'])->name('tickets.messages.store');
Route::get('/ticket/ticketFilter', [TicketController::class, 'ticketfilter'])->name('tickets.filter');
    Route::delete('/ticketdelete/{id}', [TicketController::class, 'deleteTicket']);


Route::post('/settouser', [TicketController::class, 'settouser'])->name('ticket.settouser');
Route::get('/ticket/history/{ticket_id}', [TicketController::class, 'history'])->name('ticket.history');

Route::post('/change-status/{id}', [TicketController::class, 'status'])->name('ticket.changestatus');
Route::post('/add-todo', [TodoController::class, 'add_todo'])->name('todo.add');
Route::post('/update-todo', [TodoController::class, 'update_todo'])->name('todo.update');

Route::get('/setpercentage', [TodoController::class, 'calculate_percentage']);
Route::get('/setpercentage', [TodoController::class, 'calculate_percentage']);

    
Route::post('/upload-files/{modelType}/{modelId}', [ImageUploadController::class, 'uploadFiles'])->name('upload.images');
Route::post('/upload-files-update/{modelType}/{modelId}', [ImageUploadController::class, 'uploadFilesUpdate'])->name('upload.images');
Route::post('/subtask-status', [SubtaskController::class, 'status'])->name('subtask.status');
Route::get('/subtask-analyst', [SubtaskController::class, 'analyst'])->name('subtask.analyst');
Route::post('/statusstrategy', [SubtaskController::class, 'statusstrategy'])->name('subtask.statusstrategy');
Route::get('mysubtasks', [SubtaskController::class, 'mysubtasks'])->name('subtask.mysubtasks');
Route::get('mysubtaskscalendar', [SubtaskController::class, 'mysubtaskscalendar'])->name('subtask.mysubtaskscalendar');
Route::get('addtomysubtasks', [SubtaskController::class, 'add'])->name('subtask.add');
Route::get('mysubtasks-evidence/{subtaskid}', [SubtaskController::class, 'evidence'])->name('subtask.evidence');
Route::get('settomyteam', [SubtaskController::class, 'settomyteam'])->name('subtask.settomyteam');
Route::post('settomyteamform', [SubtaskController::class, 'settomyteamform'])->name('subtask.settomyteamform');
Route::get('getassignments', [SubtaskController::class, 'getAssignments'])->name('subtask.getAssignments');
Route::get('assignment-stats', [SubtaskController::class, 'assignmentStats'])->name('subtask.assignmentStats');
Route::get('subtaskapproval', [SubtaskController::class, 'approval'])->name('subtask.approval');
Route::get('strategyEmployeeApproval', [SubtaskController::class, 'strategyEmployeeApproval'])->name('subtask.strategyEmployeeApproval');

Route::post('subtaskattachment/destroy', [SubtaskController::class, 'destroyattachement'])->name('subtask.attachment.delete');

Route::post('subtaskattachment', [SubtaskController::class, 'subtaskattachment'])->name('subtask.attachment');
Route::get('ticket/ticketshow', [TicketController::class, 'ticketshow'])->name('tickets.ticketshow');

});






// Route::get('/', function () {

   

//     // $rootTasks = Todo::where('collection_id')->with('children')->get();

// // dd( $rootTasks->completionPercentage());
//     $todos = Todo::where('level',1)->get();
    


// return view('welcome', compact('todos'));
// });


// Route::post('/upload-files/{modelType}/{modelId}', 'ImageUploadController@uploadFiles');


// Route::get('add-moasheradastrategy/{hadafstrategy}', [\App\Http\Controllers\MoasheradastrategyController::class, 'create'])->name('moasheradastrategy.add');






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





Route::get('calnewstrategy', function () {
    calculatePercentages();

    dd('in the helpers');
    
});

