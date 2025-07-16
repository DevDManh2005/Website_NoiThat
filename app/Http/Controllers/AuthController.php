<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ========================= ĐĂNG KÝ =========================

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký và gửi mã OTP đến email
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'email'      => 'required|email|unique:customers,email',
            'password'   => 'required|min:6|confirmed',
        ]);

        // Tạo mã OTP và lưu vào DB
        $otp = rand(100000, 999999);
        $customer = Customer::create([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'otp'             => $otp,
            'otp_expires_at'  => now()->addMinutes(5),
            'is_active'       => false, // Chưa kích hoạt
        ]);

        // Gửi email OTP
        Mail::to($customer->email)->send(new SendOtpMail($otp, 'xác minh tài khoản'));

        // Lưu email vào session để dùng xác minh
        session(['otp_email' => $customer->email]);

        return redirect()->route('auth.otp.form')->with('success', 'Mã OTP đã được gửi đến email.');
    }

    // ========================= XÁC MINH OTP SAU ĐĂNG KÝ =========================

    // Hiển thị form nhập OTP
    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    // Xác minh OTP sau đăng ký
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $customer = Customer::where('email', session('otp_email'))->first();

        if (!$customer || $customer->otp !== $request->otp || now()->gt($customer->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn']);
        }

        // Kích hoạt tài khoản sau khi xác minh
        $customer->update([
            'is_active' => true,
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('auth.login.form')->with('success', 'Tài khoản đã được xác minh. Vui lòng đăng nhập.');
    }

    // Gửi lại OTP khi hết hạn
    public function resendOtp()
    {
        $customer = Customer::where('email', session('otp_email'))->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản.']);
        }

        // Tạo OTP mới
        $otp = rand(100000, 999999);
        $customer->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // Gửi lại mã
        Mail::to($customer->email)->send(new SendOtpMail($otp, 'xác minh tài khoản'));

        return back()->with('success', 'Mã OTP mới đã được gửi.');
    }

    // ========================= ĐĂNG NHẬP & ĐĂNG XUẤT =========================

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Đăng nhập admin
    if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
        session(['auth_user' => Auth::guard('admin')->user()]);
        return redirect()->route('home');
    }

    // Đăng nhập nhân viên
    if (Auth::guard('employee')->attempt($request->only('email', 'password'))) {
        session(['auth_user' => Auth::guard('employee')->user()]);
        return redirect()->route('home');
    }

    // Đăng nhập khách hàng
    $customer = Customer::where('email', $request->email)->first();
    if ($customer && Hash::check($request->password, $customer->password)) {
        if (!$customer->is_active) {
            session(['otp_email' => $customer->email]);
            return redirect()->route('auth.otp.form')->withErrors(['otp' => 'Tài khoản chưa xác minh.']);
        }

        Auth::guard('web')->login($customer);
        session(['auth_user' => $customer]);
        return redirect()->route('home');
    }

    return back()->withErrors(['email' => 'Tài khoản hoặc mật khẩu không đúng.']);
}


    // Đăng xuất
    public function logout()
{
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('employee')->check()) {
        Auth::guard('employee')->logout();
    } else {
        Auth::guard('web')->logout();
    }

    session()->forget('auth_user');

    return redirect()->route('auth.login.form')->with('success', 'Đã đăng xuất.');
}

    // ========================= QUÊN MẬT KHẨU =========================

    // Hiển thị form nhập email để khôi phục mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Gửi mã OTP đặt lại mật khẩu
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Email không tồn tại.']);
        }

        $otp = rand(100000, 999999);
        $customer->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        Mail::to($customer->email)->send(new SendOtpMail($otp, 'đặt lại mật khẩu'));
        session(['reset_email' => $customer->email]);

        return redirect()->route('auth.reset.form')->with('success', 'Mã OTP đã gửi đến email.');
    }

    // Hiển thị form nhập OTP và mật khẩu mới
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    // Xử lý đổi mật khẩu mới sau khi xác thực OTP
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = Customer::where('email', session('reset_email'))->first();

        if (!$customer || $customer->otp !== $request->otp || now()->gt($customer->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn']);
        }

        $customer->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('auth.login.form')->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.');
    }

    // Gửi lại OTP đặt lại mật khẩu
    public function resendResetOtp()
    {
        $customer = Customer::where('email', session('reset_email'))->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản.']);
        }

        $otp = rand(100000, 999999);
        $customer->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        Mail::to($customer->email)->send(new SendOtpMail($otp, 'đặt lại mật khẩu'));

        return back()->with('success', 'Mã OTP mới đã được gửi.');
    }
}
