<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function dashboard(): View
    {
        $judulHalaman = 'Dashboard';
        return view('dashboard', compact('judulHalaman'));
    }

    public function login(): View
    {
        $judulHalaman = 'Login';
        $is_register = empty(User::where('role', 'admin')->first()) ? true : false;
        return view('auth.login', compact('judulHalaman', 'is_register'));
    }

    public function register()
    {
        $admin = User::where('role', 'admin')->first();
        if (!empty($admin)) {
            return redirect()->route('login');
        }
        $judulHalaman = 'Register';
        return view('auth.register', compact('judulHalaman'));
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('role', 'admin')->where('email', $request->email)->first();
        if (!empty($user) && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->ingat_saya);
            return redirect()->intended('/');
        }
        return redirect()->back()->with('error_login', 'Username atau password salah!');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,except,id'],
            'password' => ['required', 'min:8', 'string'],
            'konfirmasi_password' => ['same:password'],
        ]);
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => "admin",
        ]);
        return redirect()->route('login')->with('success_register', 'Akun anda berhasil terdaftar, silahkan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
