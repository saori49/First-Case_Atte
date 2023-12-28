<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//index
Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name("index");
});

Route::middleware(['auth'])->group(function () {
    Route::post('/start-work', [AuthController::class, 'startWork'])->name('start-work');
    Route::post('/end-work', [AuthController::class, 'endWork'])->name('end-work');
    Route::post('/start-break', [AuthController::class, 'startBreak'])->name('start-break');
    Route::post('/end-break', [AuthController::class, 'endBreak'])->name('end-break');
});

//login
Route::get('/login', [AuthController::class, "showLoginForm"])->name("showLoginForm");
Route::post('/login', [AuthController::class, "login"])->name("login");
Route::post('/logout',[AuthController::class, "logout"])->name("logout");

//register
Route::get('/register', [AuthController::class, 'create'])->middleware(['guest'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->middleware(['guest']);

//attendance
Route::get('/attendance', [AuthController::class, 'manage'])->name('manage');
Route::post('/attendance',[AuthController::class,"showAttendance"])->name('showAttendance');


Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])->name('verification.send');