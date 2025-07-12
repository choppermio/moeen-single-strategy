<?php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskDropdownController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/tasks/dropdown/{user_id}', [TaskDropdownController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/todos/{user_id}', function ($user_id) {
    $todos = Todo::where('user_id', $user_id)->where('level',5)->get();
    return $todos;
  });
  