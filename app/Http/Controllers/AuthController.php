<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{

    /* ================= REGISTER ================= */

    public function register(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:customer,seller',
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'foto'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // if ($request->role === 'seller') {
        //     $request->validate([
        //         'no_rekening' => 'required|string',
        //         'qris_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        //     ]);
        // }

        /* upload qris */
        $qrisPath = null;
        if ($request->hasFile('qris_image')) {
            $qrisPath = $request->file('qris_image')->store('qris', 'public');
        }

        /* upload foto */
        $fotoPath = $request->file('foto')->store('profile', 'public');

        User::create([
            'role'        => $request->role,
            'nik'         => $request->nik,
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'image'       => $fotoPath,
            // 'no_rekening' => $request->role === 'seller'
            //                     ? $request->no_rekening
            //                     : null,
            'qris'        => $qrisPath,
            // 'is_active'   => true,
            // 'is_online'   => false,
        ]);

        return redirect('/customer/login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    /* ================= LOGIN ================= */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Email atau password salah');
        }

        $user = Auth::guard('customer')->user();

        if (!$user->is_active) {
            Auth::logout();
            return back()->with('error', 'Akun tidak aktif');
        }

        $user->update([
            'is_active' => 'Online'
        ]);

        return redirect('/customer/dashboard');
    }

    /* ================= LOGOUT ================= */
    public function logout()
    {
        if (Auth::guard('customer')->check()) {

            Auth::guard('customer')->user()->update([
                'is_active' => 'Offline'
            ]);

            Auth::guard('customer')->logout();
        }

        return redirect('/customer/login')
            ->with('success', 'Logout berhasil');
    }

    public function index()
    {
        return view('forgot');
    }

    /* ================= FORGOT PASSWORD ================= */

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = trim(strtolower($request->email));

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        // generate OTP
        $otp = random_int(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expired' => Carbon::now()->addMinutes(5),
        ]);

        // kirim email
        Mail::raw(
            "Kode OTP reset password kamu: $otp\n\nBerlaku 5 menit.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('OTP Reset Password');
            }
        );

        return redirect('/customer/forgot-password')
            ->with('success', 'OTP berhasil dikirim ke email')
            ->with('step', 2)
            ->with('email', $request->email);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        // generate OTP 6 digit
        $otp = random_int(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expired' => Carbon::now()->addMinutes(5)
        ]);

        // kirim email
        Mail::raw(
            "Kode OTP reset password kamu: $otp\n\nOTP berlaku selama 5 menit.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('OTP Reset Password');
            }
        );

        return redirect('/customer/forgot-password')
            ->with('success', 'OTP berhasil dikirim ke email')
            ->with('step', 2)
            ->with('email', $request->email);
    }
    /* ================= RESET PASSWORD ================= */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$user) {
            return back()->with('error', 'OTP tidak valid');
        }

        // cek OTP expired
        if (!$user->otp_expired || Carbon::now()->greaterThan($user->otp_expired)) {

            $user->update([
                'otp' => null,
                'otp_expired' => null
            ]);

            return back()->with('error', 'OTP sudah kadaluarsa');
        }

        // update password
        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expired' => null
        ]);

        return redirect('/customer/login')
            ->with('success', 'Password berhasil direset');
    }
}
