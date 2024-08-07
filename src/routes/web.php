<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;

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

Fortify::verifyEmailView(function () {
	return view('auth.verify');
});

Route::middleware('auth', 'verified')->group(function () {
	Route::get('/', [WorkController::class, 'index']);
	Route::post('/work/start', [WorkController::class, 'startWork'])->name('work.start');
	Route::post('/work/end', [WorkController::class, 'endWork'])->name('work.end');
	Route::post('/break/start', [WorkController::class, 'startBreak'])->name('break.start');
	Route::post('/break/end', [WorkController::class, 'endBreak'])->name('break.end');
	Route::get('/attendance/{date?}', [AttendanceController::class, 'attendance'])->name('date.show');
	Route::get('/userlist', [UserListController::class, 'userlist'])->name('user.list');
	Route::get('/userdata',	[UserListController::class, 'userdata'])->name('user.data');
});
