<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
            'remember' => ['nullable']
        ]);

        $remember = (bool) $request->boolean('remember');
        if (Auth::attempt(['email'=>$credentials['email'], 'password'=>$credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(url()->previous() ?: '/');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')],
            'password' => ['required','string','min:6','confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign default "user" role if exists
        try {
            if (\Spatie\Permission\Models\Role::where('name','user')->exists()) {
                $user->assignRole('user');
            }
        } catch (\Throwable $e) {
            // ignore if roles not migrated yet
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
