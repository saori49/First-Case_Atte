<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AttendanceController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name("index");
});


//login
Route::get('/login', [AuthController::class, "showLoginForm"])->name("showLoginForm");
Route::post('/login', [AuthController::class, "login"])->name("login");

//register
//登録フォーム表示
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware(['guest'])
    ->name('register');
//ユーザー登録
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest']);


//打刻処理
Route::middleware(['auth'])->group(function () {
    Route::post('/start-work', [AuthController::class, 'startWork'])->name('start-work');
    Route::post('/end-work', [AuthController::class, 'endWork'])->name('end-work');
    Route::post('/start-break', [AuthController::class, 'startBreak'])->name('start-break');
    Route::post('/end-break', [AuthController::class, 'endBreak'])->name('end-break');
});

//attendance画面の表示
Route::get('/attendance', [AuthController::class, 'manage'])->name('manage');
Route::post('/attendance',[AuthController::class,"showAttendance"])->name('showAttendance');