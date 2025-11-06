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
use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\HadafstrategyController;
use App\Http\Controllers\EmployeePositionController;
use App\Http\Controllers\TicketTransitionController;
use App\Http\Controllers\MoasheradastrategyController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\EmployeePositionRelationController;
use App\Http\Controllers\PermissionController;

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

// Stats Dashboard - Admin Only (temporary fallback to old system)
Route::get('/stats/dashboard', [App\Http\Controllers\StatsController::class, 'dashboard'])
    ->name('stats.dashboard')
    ->middleware('auth'); // Temporarily removed admin check

// Original permission-based route (for when permissions are working)
Route::get('/stats/dashboard-permissions', [App\Http\Controllers\StatsController::class, 'dashboard'])
    ->name('stats.dashboard.permissions')
    ->middleware(['auth', 'permission:view_statistics_dashboard']);

// Temporary bypass for testing (remove after fixing)
Route::get('/stats/dashboard-test', [App\Http\Controllers\StatsController::class, 'dashboard'])
    ->name('stats.dashboard.test')
    ->middleware('auth');

// User Management Routes (for debugging login issues)
Route::get('/user-management', function () {
    return view('user-management');
})->name('user.management')->middleware(['auth', 'permission:manage_permissions']);

// Organizational Hierarchy - Admin Only
Route::get('/stats/hierarchy', [App\Http\Controllers\StatsController::class, 'hierarchy'])
    ->name('stats.hierarchy')
    ->middleware(['auth', 'permission:view_hierarchy']);

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

// Test route with permission middleware
Route::get('/test-permission', function() {
    return "✅ Permission middleware is working! You have the required permissions.";
})->middleware(['auth', 'permission:view_dashboard']);

// Permission testing routes
Route::get('/permission-test', [App\Http\Controllers\PermissionTestController::class, 'index'])->middleware('auth')->name('permission.test');
Route::get('/permission-test/{permission}', [App\Http\Controllers\PermissionTestController::class, 'test'])->middleware('auth')->name('permission.test.specific');

// Quick permission assignment for testing (temporary - remove in production)
Route::get('/assign-dashboard-permission', function() {
    $user = auth()->user();
    if (!$user) {
        return 'لم يتم تسجيل الدخول';
    }
    
    $position = \App\Models\EmployeePosition::where('user_id', $user->id)->first();
    if (!$position) {
        return 'لم يتم العثور على منصب وظيفي للمستخدم';
    }
    
    $permission = \App\Models\Permission::where('name', 'view_statistics_dashboard')->first();
    if (!$permission) {
        return 'لم يتم العثور على صلاحية view_statistics_dashboard';
    }
    
    // Check if already assigned
    if ($position->permissions()->where('permission_id', $permission->id)->exists()) {
        return 'الصلاحية مخصصة بالفعل للمنصب: ' . $position->name;
    }
    
    // Assign permission
    $position->permissions()->attach($permission->id);
    
    return 'تم تخصيص صلاحية لوحة الإحصائيات للمنصب: ' . $position->name . '<br><a href="/stats/dashboard">اذهب إلى لوحة الإحصائيات</a>';
})->middleware('auth');

// Debug permission status
Route::get('/debug-permissions', function() {
    $user = auth()->user();
    if (!$user) {
        return 'No authenticated user';
    }
    
    $position = \App\Models\EmployeePosition::where('user_id', $user->id)->first();
    if (!$position) {
        return 'No employee position found for user: ' . $user->name;
    }
    
    $output = [];
    $output[] = '<h3>Permission Debug Information</h3>';
    $output[] = '<strong>User:</strong> ' . $user->name . ' (ID: ' . $user->id . ')';
    $output[] = '<strong>Employee Position:</strong> ' . $position->name . ' (ID: ' . $position->id . ')';
    
    // Check specific permission
    $permission = \App\Models\Permission::where('name', 'view_statistics_dashboard')->first();
    if ($permission) {
        $hasPermission = $position->permissions()->where('permission_id', $permission->id)->exists();
        $output[] = '<strong>Has view_statistics_dashboard permission:</strong> ' . ($hasPermission ? 'YES' : 'NO');
        
        // Test helper function
        $helperResult = has_permission('view_statistics_dashboard');
        $output[] = '<strong>has_permission() function result:</strong> ' . ($helperResult ? 'TRUE' : 'FALSE');
        
        // Test position method
        $positionResult = $position->hasPermission('view_statistics_dashboard');
        $output[] = '<strong>$position->hasPermission() result:</strong> ' . ($positionResult ? 'TRUE' : 'FALSE');
    } else {
        $output[] = '<strong>Permission "view_statistics_dashboard" not found in database!</strong>';
    }
    
    // List all permissions for this position
    $allPermissions = $position->permissions()->pluck('name')->toArray();
    $output[] = '<strong>All permissions for this position:</strong><br>' . 
                (count($allPermissions) > 0 ? implode('<br>', $allPermissions) : 'None');
    
    // Check if permission exists in pivot table
    $pivotCount = \DB::table('employee_position_permission')
        ->where('employee_position_id', $position->id)
        ->count();
    $output[] = '<strong>Total permissions in pivot table:</strong> ' . $pivotCount;
    
    return implode('<br><br>', $output);
})->middleware('auth');

// Debug admin status
Route::get('/debug-admin', function() {
    $user = auth()->user();
    if (!$user) {
        return 'No authenticated user';
    }
    
    $position = \App\Models\EmployeePosition::where('user_id', $user->id)->first();
    
    $output = [];
    $output[] = '<h3>Admin Debug Information</h3>';
    $output[] = '<strong>User:</strong> ' . $user->name . ' (ID: ' . $user->id . ')';
    $output[] = '<strong>Employee Position:</strong> ' . ($position ? $position->name . ' (ID: ' . $position->id . ')' : 'None');
    
    // Check ADMIN_ID environment variable
    $adminIds = env('ADMIN_ID', '');
    $output[] = '<strong>ADMIN_ID from .env:</strong> ' . ($adminIds ?: 'Not set');
    
    // Test both is_admin functions
    try {
        $adminByUserId = in_array($user->id, explode(',', $adminIds));
        $output[] = '<strong>Admin by User ID:</strong> ' . ($adminByUserId ? 'YES' : 'NO');
    } catch (Exception $e) {
        $output[] = '<strong>Admin by User ID:</strong> Error - ' . $e->getMessage();
    }
    
    try {
        $adminByPositionId = $position ? in_array($position->id, explode(',', $adminIds)) : false;
        $output[] = '<strong>Admin by Position ID:</strong> ' . ($adminByPositionId ? 'YES' : 'NO');
    } catch (Exception $e) {
        $output[] = '<strong>Admin by Position ID:</strong> Error - ' . $e->getMessage();
    }
    
    // Test is_admin helper function
    try {
        $isAdminResult = is_admin();
        $output[] = '<strong>is_admin() function result:</strong> ' . ($isAdminResult ? 'TRUE' : 'FALSE');
    } catch (Exception $e) {
        $output[] = '<strong>is_admin() function result:</strong> Error - ' . $e->getMessage();
    }
    
    return implode('<br><br>', $output);
})->middleware('auth');

// Force assign all permissions (for testing only)
Route::get('/force-assign-all-permissions', function() {
    $user = auth()->user();
    if (!$user) {
        return 'No authenticated user';
    }
    
    $position = \App\Models\EmployeePosition::where('user_id', $user->id)->first();
    if (!$position) {
        return 'No employee position found for user: ' . $user->name;
    }
    
    // Get all permission IDs
    $allPermissionIds = \App\Models\Permission::pluck('id')->toArray();
    
    // Assign all permissions to this position
    $position->permissions()->sync($allPermissionIds);
    
    $assignedCount = count($allPermissionIds);
    
    return "تم تخصيص جميع الصلاحيات ($assignedCount) للمنصب: " . $position->name . 
           '<br><br><a href="/debug-permissions">تحقق من الصلاحيات</a>' .
           '<br><a href="/stats/dashboard">اذهب إلى لوحة الإحصائيات</a>';
})->middleware('auth');

// Quick admin fix - makes current user an admin
Route::get('/make-me-admin', function() {
    $user = auth()->user();
    if (!$user) {
        return 'No authenticated user';
    }
    
    $position = \App\Models\EmployeePosition::where('user_id', $user->id)->first();
    if (!$position) {
        return 'No employee position found for user: ' . $user->name;
    }
    
    // Give manage_permissions permission to current user
    $managePermissionsPermission = \App\Models\Permission::where('name', 'manage_permissions')->first();
    if ($managePermissionsPermission && !$position->permissions()->where('permission_id', $managePermissionsPermission->id)->exists()) {
        $position->permissions()->attach($managePermissionsPermission->id);
    }
    
    // Instructions to add to .env
    $output = [];
    $output[] = '<h3>Admin Setup Instructions</h3>';
    $output[] = '<strong>Your User ID:</strong> ' . $user->id;
    $output[] = '<strong>Your Position ID:</strong> ' . $position->id;
    $output[] = '<strong>Current ADMIN_ID in .env:</strong> ' . (env('ADMIN_ID') ?: 'Not set');
    
    $output[] = '<hr>';
    $output[] = '<h4>Permission System Setup Complete!</h4>';
    $output[] = 'You now have the "manage_permissions" permission assigned.';
    $output[] = '<br><a href="/permissions" class="btn btn-primary">Go to Permissions Management</a>';
    
    $output[] = '<hr>';
    $output[] = '<h4>Option 1: Add to .env file (for legacy admin functions)</h4>';
    $output[] = 'Add or update this line in your .env file:';
    $output[] = '<code>ADMIN_ID=' . $user->id . ',' . $position->id . '</code>';
    $output[] = '<small>This makes you admin by both User ID and Position ID</small>';
    
    $output[] = '<hr>';
    $output[] = '<h4>Option 2: Use permission system (Recommended)</h4>';
    $output[] = '<a href="/force-assign-all-permissions" class="btn btn-primary">Assign All Permissions</a>';
    
    return implode('<br>', $output);
})->middleware('auth');

// Test route with admin middleware (for testing old vs new system)
Route::get('/test-admin', function() {
    return "✅ Admin access working! You are an admin user.";
})->middleware(['auth'])->name('test.admin');

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
Route::get('/change-password', [PasswordController::class, 'index'])->name('password.change')->middleware('auth');

// Permissions Management (Admin only)
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware(['auth', 'permission:manage_permissions']);
Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware(['auth', 'permission:manage_permissions']);
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware(['auth', 'permission:manage_permissions']);
Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware(['auth', 'permission:manage_permissions']);
Route::post('/permissions/{id}/update', [PermissionController::class, 'updatePermission'])->name('permissions.updatePermission')->middleware(['auth', 'permission:manage_permissions']);
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware(['auth', 'permission:manage_permissions']);
Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update')->middleware(['auth', 'permission:manage_permissions']);
Route::get('/permissions/{id}', [PermissionController::class, 'getPermissions'])->name('permissions.get')->middleware(['auth', 'permission:manage_permissions']);

// Task Management - pause/unpause and attachments
Route::post('/task/toggle-hidden', [TaskManagementController::class, 'toggleHidden'])->name('task.toggleHidden')->middleware('auth');
Route::get('/task/{id}/attachments', [TaskManagementController::class, 'getAttachments'])->name('task.getAttachments')->middleware('auth');
Route::post('/task/{id}/upload-attachments', [TaskManagementController::class, 'uploadAttachments'])->name('task.uploadAttachments')->middleware('auth');
Route::delete('/task/{id}/attachments/{mediaId}', [TaskManagementController::class, 'deleteAttachment'])->name('task.deleteAttachment')->middleware('auth');

Route::group(['middleware' => 'checkUserId'], function () {
    // Routes accessible only to the user with ID 1
    Route::resource('hadafstrategies', '\App\Http\Controllers\HadafstrategyController')->middleware('permission:view_strategic_goals');
    Route::get('/send-notification', [SubtaskController::class, 'sendNotification']);

    Route::get('/hadafstrategies/{id}/edit', [HadafstrategyController::class, 'edit'])->name('hadafstrategies.edit')->middleware('permission:manage_strategic_goals');

    Route::resource('moasheradastrategy', '\App\Http\Controllers\MoasheradastrategyController')->middleware('permission:view_strategic_indicators');
Route::get('/moasheradastrategy/{id}/edit', [MoasheradastrategyController::class, 'edit'])->name('Moasheradastrategy.edit')->middleware('permission:manage_strategic_indicators');
Route::resource('moashermkmf', '\App\Http\Controllers\MoashermkmfController')->middleware('permission:view_efficiency_indicators');
Route::resource('task', '\App\Http\Controllers\TaskController')->middleware('permission:view_main_tasks');
Route::get('/get-tasks', [TaskController::class, 'getTasksByUserId'])->middleware('permission:view_main_tasks');

Route::resource('mubadara', '\App\Http\Controllers\MubadaraController')->middleware('permission:view_initiatives');


});





Route::group(['middleware' => 'auth'], function () {
    Route::post('removetaskmkmf',[HadafstrategyController::class, 'removeTaskMoasher'])->name('removetaskmkmf');
Route::resource('subtask', '\App\Http\Controllers\SubtaskController')->middleware('permission:view_subtasks');
Route::get('employeepositionstop', [EmployeePositionController::class, 'top']);

Route::resource('employeepositions', '\App\Http\Controllers\EmployeePositionController');
Route::get('employeepositions/team/{id}', [EmployeePositionController::class, 'team']);

Route::post('attach-users-store/{position_id}', [EmployeePositionController::class, 'attach_users_store']);
Route::get('attach-users/{position_id}', [EmployeePositionController::class, 'attach_users']);
Route::get('employee-position-delete/{id}',[EmployeePositionRelationController::class, 'destroy']);

    //create post route for this method changeTask in subtaskcontroller
    Route::post('/change-task', [SubtaskController::class, 'changeTask'])->name('subtask.changeTask')->middleware('permission:manage_subtasks');
    // AJAX route: update subtask percentage
    Route::post('/subtask/update-percentage', [SubtaskController::class, 'updatePercentage'])->name('subtask.updatePercentage')->middleware('permission:manage_subtasks');
    // AJAX bulk approve route
    Route::post('/subtask/bulk-statusstrategy', [SubtaskController::class, 'bulkStatusStrategy'])->name('subtask.bulkStatusStrategy')->middleware('permission:approve_tasks');
    Route::post('/ticket-transitions', [TicketTransitionController::class, 'store']);
    
    Route::get('/', function () {
        $todos ='a';
        
        
        
        return view('employeepositionstop', compact('todos'));
    });    Route::get('/', [EmployeePositionController::class, 'top']);

    Route::resource('tickets', '\App\Http\Controllers\TicketController')->middleware('permission:view_tickets');

Route::get('/ticketsshow/{id}', [TicketController::class, 'showwithmessages'])->name('tickets.showwithmessages')->middleware('permission:view_tickets');
Route::post('/tickets/{id}/messages', [TicketController::class, 'storeMessage'])->name('tickets.messages.store')->middleware('permission:view_tickets');
Route::get('/ticket/ticketFilter', [TicketController::class, 'ticketfilter'])->name('tickets.filter')->middleware('permission:view_tickets');
    // Route::delete('/ticketdelete/{id}', [TicketController::class, 'deleteTicket']);

// Admin ticket routes (only accessible by ADMIN_ID users)
Route::get('/admin/tickets', [TicketController::class, 'adminIndex'])->name('tickets.admin.index')->middleware('permission:manage_all_tickets');
Route::get('/admin/tickets/{id}/edit', [TicketController::class, 'adminEdit'])->name('tickets.admin.edit')->middleware('permission:manage_all_tickets');
Route::put('/admin/tickets/{id}', [TicketController::class, 'adminUpdate'])->name('tickets.admin.update')->middleware('permission:manage_all_tickets');
Route::delete('/admin/tickets/{id}', [TicketController::class, 'adminDestroy'])->name('tickets.admin.destroy')->middleware('permission:manage_all_tickets');
Route::delete('/admin/tickets/{id}/remove-file', [TicketController::class, 'adminRemoveFile'])->name('tickets.admin.removeFile')->middleware('permission:manage_all_tickets');

Route::post('/settouser', [TicketController::class, 'settouser'])->name('ticket.settouser')->middleware('permission:view_tickets');
Route::get('/ticket/history/{ticket_id}', [TicketController::class, 'history'])->name('ticket.history')->middleware('permission:view_tickets');

Route::post('/change-status/{id}', [TicketController::class, 'status'])->name('ticket.changestatus')->middleware('permission:view_tickets');
Route::post('/add-todo', [TodoController::class, 'add_todo'])->name('todo.add');
Route::post('/update-todo', [TodoController::class, 'update_todo'])->name('todo.update');

Route::get('/setpercentage', [TodoController::class, 'calculate_percentage']);
Route::get('/setpercentage', [TodoController::class, 'calculate_percentage']);

    
Route::post('/upload-files/{modelType}/{modelId}', [ImageUploadController::class, 'uploadFiles'])->name('upload.images');
Route::post('/upload-files-update/{modelType}/{modelId}', [ImageUploadController::class, 'uploadFilesUpdate'])->name('upload.images');
Route::post('/subtask-status', [SubtaskController::class, 'status'])->name('subtask.status')->middleware('permission:manage_subtasks');
Route::get('/subtask-analyst', [SubtaskController::class, 'analyst'])->name('subtask.analyst')->middleware('permission:view_monthly_statistics');
Route::post('/statusstrategy', [SubtaskController::class, 'statusstrategy'])->name('subtask.statusstrategy')->middleware('permission:approve_tasks');
    // Overdue subtasks for admin
    Route::get('/subtask/overdue', [SubtaskController::class, 'overdue'])->name('subtask.overdue')->middleware('permission:view_overdue_tasks');
    // Temporary public route for debugging (no auth) - remove after verification
Route::get('mysubtasks', [SubtaskController::class, 'mysubtasks'])->name('subtask.mysubtasks')->middleware('permission:view_my_tasks');
Route::get('mysubtaskscalendar', [SubtaskController::class, 'mysubtaskscalendar'])->name('subtask.mysubtaskscalendar')->middleware('permission:view_calendar');
Route::get('addtomysubtasks', [SubtaskController::class, 'add'])->name('subtask.add')->middleware('permission:view_my_tasks');
Route::get('mysubtasks-evidence/{subtaskid}', [SubtaskController::class, 'evidence'])->name('subtask.evidence')->middleware('permission:view_my_tasks');
Route::get('settomyteam', [SubtaskController::class, 'settomyteam'])->name('subtask.settomyteam')->middleware('permission:assign_to_team');
Route::post('settomyteamform', [SubtaskController::class, 'settomyteamform'])->name('subtask.settomyteamform')->middleware('permission:assign_to_team');
Route::get('getassignments', [SubtaskController::class, 'getAssignments'])->name('subtask.getAssignments')->middleware('permission:assign_to_team');
Route::get('assignment-stats', [SubtaskController::class, 'assignmentStats'])->name('subtask.assignmentStats')->middleware('permission:view_assignment_stats');
Route::get('subtaskapproval', [SubtaskController::class, 'approval'])->name('subtask.approval')->middleware('permission:approve_tasks');
Route::get('strategyEmployeeApproval', [SubtaskController::class, 'strategyEmployeeApproval'])->name('subtask.strategyEmployeeApproval')->middleware('permission:strategy_employee_approval');

Route::post('subtaskattachment/destroy', [SubtaskController::class, 'destroyattachement'])->name('subtask.attachment.delete')->middleware('permission:manage_subtasks');

Route::post('subtaskattachment', [SubtaskController::class, 'subtaskattachment'])->name('subtask.attachment')->middleware('permission:manage_subtasks');
Route::get('ticket/ticketshow', [TicketController::class, 'ticketshow'])->name('tickets.ticketshow')->middleware('permission:view_tickets');

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

