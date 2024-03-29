<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use App\Models\Ticket;
use App\Models\Transaction;
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
        $user = User::count();
        $transaksi = Transaction::count();
        $tiket = Ticket::count();
        $kapal = Ship::count();
        return view('dashboard', compact('judulHalaman', 'user', 'transaksi', 'tiket', 'kapal'));
    }

    public function profile(): View
    {
        $judulHalaman = 'Dashboard';
        return view('auth.profile', compact('judulHalaman'));
    }

    public function postProfile(Request $request)
    {
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', $request->email == auth()->user()->email ? '' : 'unique:users,email,except,id'],
            'no_hp' => ['required'],
            'alamat' => ['required'],
            'password' => ['nullable'],
            'konfirmasi_password' => ['same:password'],
        ]);

        $user = User::findOrFail(auth()->user()->id);
        if (empty($request->password)) {
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        } else {
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('/profile')
            ->with('success', 'Profile berhasil diperbarui!');
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
        // return $request->all();
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,except,id'],
            'password' => ['required', 'min:8', 'string'],
            'konfirmasi_password' => ['same:password'],
            'role' => ['required', 'in:admin'],
        ]);
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
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
