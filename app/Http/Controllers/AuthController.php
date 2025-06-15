<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // change as needed
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function sendPasswordResetLink(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Attempt to send the reset link
        $status = Password::sendResetLink($request->only('email'));

        // Check if the email was sent successfully
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status)) // Success message
            : back()->withErrors(['email' => __($status)]); // Error message
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        // Validate input fields
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        // Reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                Auth::login($user);
            }
        );

        // Redirect based on success or failure
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password reset successful. You can now log in.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function startImpersonation(User $user)
    {
        Gate::authorize('impersonate', $user);

        // if (!$user->is_active) {
        //     return back()->with('error', 'User Inactive!');
        // }

        Session::put('impersonate.admin_id', Auth::id());

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'You are now impersonating another user.'); // or wherever you want to land after impersonation
    }

    public function stopImpersonation()
    {
        if (! Session::has('impersonate.admin_id')) {
            abort(403, 'You are not impersonating.');
        }

        $adminId = Session::pull('impersonate.admin_id');

        $admin = User::find($adminId);

        if (! $admin) {
            Auth::logout();
            return redirect('/login')->with('error', 'Original admin not found.');
        }

        Auth::login($admin);

        return redirect('/dashboard')->with('success', 'Switched back to admin.'); // back to admin dashboard or wherever you prefer
    }
}
