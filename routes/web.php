<?php

use App\Models\Task;
use App\Models\Subtask;
use App\Models\Mubadara;
use App\Models\Moashermkmf;
use App\Models\Hadafstrategy;
use App\Models\Moasheradastrategy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
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
    Route::get('/subtask/overdue-public', [SubtaskController::class, 'overdue'])->name('subtask.overdue.public');

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

// Stats API for auto-updating sidebar badges
Route::get('/api/stats/sidebar-notifications', [App\Http\Controllers\StatsController::class, 'sidepanelnotificationnumber'])->name('stats.sidebar');

// Stats Dashboard - Admin Only
Route::get('/stats/dashboard', [App\Http\Controllers\StatsController::class, 'dashboard'])
    ->name('stats.dashboard')
    ->middleware('auth');

// User Management Routes (for debugging login issues)
Route::get('/user-management', function () {
    return view('user-management');
})->name('user.management');

// Organizational Hierarchy - Admin Only
Route::get('/stats/hierarchy', [App\Http\Controllers\StatsController::class, 'hierarchy'])
    ->name('stats.hierarchy')
    ->middleware('auth');

Route::get('/user-management/api/users', function () {
    try {
        $users = App\Models\User::select('id', 'name', 'email', 'position', 'level')->get();
        return response()->json(['success' => true, 'users' => $users]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});

Route::post('/user-management/api/reset-password', function (Illuminate\Http\Request $request) {
    try {
        $user = App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'المستخدم غير موجود']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'تم إعادة تعيين كلمة المرور بنجاح']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});

Route::post('/user-management/api/create-user', function (Illuminate\Http\Request $request) {
    try {
        $existingUser = App\Models\User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json(['success' => false, 'message' => 'البريد الإلكتروني مستخدم بالفعل']);
        }
        
        $user = new App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->position = $request->position;
        $user->level = $request->level ?: 1;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'تم إنشاء المستخدم بنجاح']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});

Route::post('/user-management/api/test-login', function (Illuminate\Http\Request $request) {
    try {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::logout(); // Logout immediately after test
            return response()->json([
                'success' => true, 
                'message' => 'تسجيل الدخول ناجح',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'position' => $user->position ?? null
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'البيانات غير صحيحة']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});

// Quick fix route - Reset CEO password to known value
Route::get('/fix-login', function() {
    try {
        $user = App\Models\User::where('email', 'ceo@moeen-sa.com')->first();
        if ($user) {
            $user->password = Hash::make('123456');
            $user->save();
            return "CEO password reset to: 123456<br>Email: ceo@moeen-sa.com<br>You can now login with these credentials.<br><a href='/login'>Go to Login Page</a>";
        } else {
            // Create admin user if CEO doesn't exist
            $user = new App\Models\User();
            $user->name = 'Administrator';
            $user->email = 'admin@moeen-sa.com';
            $user->password = Hash::make('admin123');
            $user->position = 'admin';
            $user->level = 1;
            $user->save();
            return "Admin user created:<br>Email: admin@moeen-sa.com<br>Password: admin123<br><a href='/login'>Go to Login Page</a>";
        }
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Simple test route
Route::get('/test-simple', function() {
    return "✅ Routes are working! Database users: " . App\Models\User::count();
});

// Debug Login Interface
Route::get('/debug-login', function() {
    try {
        $users = App\Models\User::select('id', 'name', 'email', 'password', 'position', 'level')->limit(10)->get();
        $totalUsers = App\Models\User::count();
        
        return view('debug-login', compact('users', 'totalUsers'));
    } catch (\Exception $e) {
        return "Database Error: " . $e->getMessage();
    }
});

Route::post('/debug-login/reset-password', function(Illuminate\Http\Request $request) {
    try {
        $user = App\Models\User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make('123456');
            $user->save();
            return response()->json(['success' => true, 'message' => 'Password reset to 123456 for ' . $user->email]);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});

Route::post('/debug-login/reset-all', function() {
    try {
        $users = App\Models\User::all();
        foreach ($users as $user) {
            $user->password = Hash::make('123456');
            $user->save();
        }
        return response()->json(['success' => true, 'message' => 'All passwords reset to 123456']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});

Route::post('/debug-login/test-hash', function() {
    $hash = Hash::make('123456');
    return response()->json(['hash' => $hash]);
});

Route::post('/debug-login/test-auth', function(Illuminate\Http\Request $request) {
    try {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        
        // First check if user exists
        $user = App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false, 
                'message' => 'User not found',
                'debug' => 'Email ' . $request->email . ' does not exist in database'
            ]);
        }
        
        // Check if password matches
        if (Hash::check($request->password, $user->password)) {
            // Try Laravel Auth
            if (Auth::attempt($credentials)) {
                $authUser = Auth::user();
                Auth::logout(); // Logout immediately after test
                return response()->json([
                    'success' => true,
                    'message' => 'Authentication successful',
                    'user' => [
                        'id' => $authUser->id,
                        'name' => $authUser->name,
                        'email' => $authUser->email
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password matches but Auth::attempt failed',
                    'debug' => 'Hash matches manually but Laravel Auth failed'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password does not match',
                'debug' => 'Hash check failed for stored password'
            ]);
        }
    } catch (\Exception $e) {        return response()->json([
            'success' => false,
            'message' => 'Exception: ' . $e->getMessage(),
            'debug' => $e->getTraceAsString()
        ]);
    }
});

Route::post('/change-password', [PasswordController::class, 'store'])->name('password.update2');

Route::group(['middleware' => 'checkUserId'], function () {
    // Routes accessible only to the user with ID 1
    Route::resource('hadafstrategies', '\App\Http\Controllers\HadafstrategyController');
    Route::get('/send-notification', [SubtaskController::class, 'sendNotification']);

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
    // AJAX route: update subtask percentage
    Route::post('/subtask/update-percentage', [SubtaskController::class, 'updatePercentage'])->name('subtask.updatePercentage');
    // AJAX bulk approve route
    Route::post('/subtask/bulk-statusstrategy', [SubtaskController::class, 'bulkStatusStrategy'])->name('subtask.bulkStatusStrategy');
    Route::post('/ticket-transitions', [TicketTransitionController::class, 'store']);
    
    Route::get('/', function () {
        $todos ='a';
        
        
        
        return view('employeepositionstop', compact('todos'));
    });    Route::get('/', [EmployeePositionController::class, 'top']);

    Route::resource('tickets', '\App\Http\Controllers\TicketController');

Route::get('/ticketsshow/{id}', [TicketController::class, 'showwithmessages'])->name('tickets.showwithmessages');
Route::post('/tickets/{id}/messages', [TicketController::class, 'storeMessage'])->name('tickets.messages.store');
Route::get('/ticket/ticketFilter', [TicketController::class, 'ticketfilter'])->name('tickets.filter');
    // Route::delete('/ticketdelete/{id}', [TicketController::class, 'deleteTicket']);

// Admin ticket routes (only accessible by ADMIN_ID users)
Route::get('/admin/tickets', [TicketController::class, 'adminIndex'])->name('tickets.admin.index');
// Route::get('/admin/tickets/{id}/edit', [TicketController::class, 'adminEdit'])->name('tickets.admin.edit');
Route::put('/admin/tickets/{id}', [TicketController::class, 'adminUpdate'])->name('tickets.admin.update');
Route::delete('/admin/tickets/{id}', [TicketController::class, 'adminDestroy'])->name('tickets.admin.destroy');
Route::delete('/admin/tickets/{id}/remove-file', [TicketController::class, 'adminRemoveFile'])->name('tickets.admin.removeFile');

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
    // Overdue subtasks for admin
    Route::get('/subtask/overdue', [SubtaskController::class, 'overdue'])->name('subtask.overdue');
    // Temporary public route for debugging (no auth) - remove after verification
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


 Route::get('newstrategy', function () {
        $todos ='a';
        
        
        
        return view('newstrategy', compact('todos'));
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

