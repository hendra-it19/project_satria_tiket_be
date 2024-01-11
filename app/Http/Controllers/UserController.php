<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $judulHalaman = 'Akun';
    private $role = ['admin', 'pengguna'];

    public function index()
    {
        $judulHalaman = $this->judulHalaman;
        $data = User::OrderBy('id', 'DESC')->get();
        $no = 1;
        return view('users.index', compact('data', 'judulHalaman', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $judulHalaman = $this->judulHalaman;
        $role = $this->role;
        return view('users.create', compact('judulHalaman', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->role;
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,except,id'],
            'hp' => ['nullable', 'unique:users,hp,except,id'],
            'alamat' => ['nullable'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,pengguna'],
            'konfirmasi_password' => ['same:password'],
        ]);
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('users.index')
            ->with('success', 'Data akun baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $judulHalaman = $this->judulHalaman;
        $role = $this->role;
        return view('users.update', compact('judulHalaman', 'user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (empty($request->password)) {
            $request->validate([
                'nama' => ['required'],
                'email' => ['required', 'email', $request->email == $user->email ? '' :  'unique:users,email,except,id'],
                'hp' => ['nullable', $request->hp == $user->hp ? '' :  'unique:users,hp,except,id'],
                'alamat' => ['nullable'],
                'role' => ['required', 'in:admin,pengguna'],
            ]);
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->hp,
                'alamat' => $request->alamat,
                'role' => $request->role,
            ]);
            return redirect()->route('users.index')
                ->with('success', 'Data akun baru berhasil diperbarui!');
        }
        $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', $request->email == $user->email ? '' :  'unique:users,email,except,id'],
            'hp' => ['nullable', $request->hp == $user->hp ? '' :  'unique:users,hp,except,id'],
            'alamat' => ['nullable'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,pengguna'],
            'konfirmasi_password' => ['same:password'],
        ]);
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('users.index')
            ->with('success', 'Data akun baru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $transaction = Transaction::where('user_id', $user->id)->first();
        if (empty($transaction)) {
            $user->delete();
            return redirect()->back()
                ->with('success', 'Data akun berhasil dihapus!');
        }
        return redirect()->back()
            ->with('error', 'Data pengguna masih tercatat dalam transaksi!');
    }
}
