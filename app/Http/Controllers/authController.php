<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'phone.required' => 'ফোন নাম্বার দিতে হবে।',
            'password.required' => 'পাসওয়ার্ড দিতে হবে।',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('courses.index'));
        }

        return back()
            ->withErrors(['phone' => 'ফোন নাম্বার বা পাসওয়ার্ড সঠিক নয়।'])
            ->onlyInput('phone');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'name.required' => 'নাম দিতে হবে।',
            'phone.required' => 'ফোন নাম্বার দিতে হবে।',
            'phone.unique' => 'এই ফোন নাম্বার দিয়ে আগেই অ্যাকাউন্ট খোলা আছে।',
            'password.required' => 'পাসওয়ার্ড দিতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড দুইবার একই দিতে হবে।',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('courses.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
