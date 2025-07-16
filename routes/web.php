<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\CustomerController;

// ===================== TRANG CHỦ =====================
Route::get('/', function () {
    return view('index');
})->name('home');

// ===================== XÁC THỰC DÙNG CHUNG =====================

// ---- Đăng ký ----
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// ---- Xác minh OTP sau đăng ký ----
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('auth.otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.otp.verify');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.otp.resend');

// ---- Đăng nhập / đăng xuất ----
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// ---- Quên mật khẩu ----
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot.form');
Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])->name('auth.forgot.send');

Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('auth.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset');
Route::post('/resend-reset-otp', [AuthController::class, 'resendResetOtp'])->name('auth.reset.resend');

// ===================== ADMIN =====================
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// ===================== NHÂN VIÊN =====================
Route::prefix('employee')->name('employee.')->middleware('employee')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
});


// CRUD Admin
Route::middleware(['auth.admin'])->prefix('admin/manage-admins')->name('admin.manage-admins.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
});

// CRUD Employee
Route::middleware(['auth.admin'])->prefix('admin/manage-employees')->name('admin.manage-employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/', [EmployeeController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
});

// CRUD Customer
Route::middleware(['auth.admin'])->prefix('admin/manage-customers')->name('admin.manage-customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});
