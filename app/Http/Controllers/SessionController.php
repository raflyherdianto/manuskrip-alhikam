<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    /**
     * Show login form
     */
    public function index()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('session.login');
    }

    /**
     * Show admin login form
     */
    public function adminLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin');
        }

        return view('session.admin-login');
    }

    /**
     * Show superadmin login form
     */
    public function superadminLogin()
    {
        if (Auth::check() && Auth::user()->role === 'superadmin') {
            return redirect()->route('superadmin');
        }

        return view('session.superadmin-login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Determine login type from referer URL
        $referer = $request->headers->get('referer');
        $isAdminLogin = $referer && (str_contains($referer, '/admin/login'));
        $isSuperadminLogin = $referer && (str_contains($referer, '/superadmin/login'));

        // Debug: Log the current route and referer
        Log::info('Login attempt from referer: ' . $referer);
        Log::info('Admin login: ' . ($isAdminLogin ? 'yes' : 'no') . ', Superadmin login: ' . ($isSuperadminLogin ? 'yes' : 'no'));

        if ($isAdminLogin || $isSuperadminLogin) {
            // Admin/Superadmin login - validate email and password
            Log::info('Processing admin/superadmin login');

            $request->validate([
                'name' => 'required|email',
                'password' => 'required',
            ], [
                'name.required' => "Email harus diisi",
                'name.email' => "Format email tidak valid",
                'password.required' => "Password harus diisi",
            ]);

            // Find user by email
            $user = User::where('email', $request->name)->first();

            // Check if user exists
            if (!$user) {
                Log::warning('Email not found: ' . $request->name);
                return back()
                    ->withErrors(['login' => 'Email tidak ditemukan'])
                    ->withInput();
            }

            // Check role matches the login page
            if ($isSuperadminLogin && $user->role !== 'superadmin') {
                return back()
                    ->withErrors(['login' => 'Anda tidak memiliki akses sebagai Superadmin'])
                    ->withInput();
            }

            if ($isAdminLogin && !$isSuperadminLogin && $user->role !== 'admin') {
                return back()
                    ->withErrors(['login' => 'Anda tidak memiliki akses sebagai Admin'])
                    ->withInput();
            }
        } else {
            // Student login - validate NIM
            Log::info('Processing student login');

            $request->validate([
                'name' => 'required',
                'password' => 'required',
            ], [
                'name.required' => "NIM harus diisi",
                'password.required' => "Password harus diisi",
            ]);

            // Try to find user by NIM (for students)
            $user = User::where('nim', $request->name)->first();

            // Check if user exists
            if (!$user) {
                Log::warning('NIM not found: ' . $request->name);
                return back()
                ->withErrors(['login' => 'NIM tidak ditemukan'])
                ->withInput();
            }
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()
            ->withErrors(['login' => 'Password salah'])
            ->withInput();
        }

        // Store intended URL from form if provided
        if ($request->has('intended_url') && $request->input('intended_url')) {
            session()->put('url.intended', $request->input('intended_url'));
        }

        // Manually login the user
        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    /**
     * Redirect user based on role
     */
    private function redirectByRole($user)
    {
        switch($user->role) {
            case 'superadmin':
                return redirect('/superadmin/dashboard')->with('success', 'Login berhasil sebagai Superadmin');
            case 'admin':
                return redirect('/admin/dashboard')->with('success', 'Login berhasil sebagai Admin');
            case 'user':
            default:
                // Redirect to profile if user is not verified
                if (!$user->verified) {
                    return redirect()->route('activity.profile')->with('warning', 'Silakan verifikasi akun Anda dengan mengubah email dan password');
                }

                // Check if there's an intended URL and it's not the home page
                $intended = session()->pull('url.intended');
                if ($intended && $intended !== url('/') && $intended !== route('home')) {
                    return redirect($intended)->with('success', 'Login berhasil');
                }

                return redirect()->route('activity')->with('success', 'Login berhasil');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect based on user role
        if ($role === 'admin') {
            return redirect()->route('admin.login')->with('success', 'Berhasil Logout');
        } elseif ($role === 'superadmin') {
            return redirect()->route('superadmin.login')->with('success', 'Berhasil Logout');
        }

        return redirect('login')->with('success', 'Berhasil Logout');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('session.forgot-password');
    }

    /**
     * Send reset password link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('session.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Handle reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
