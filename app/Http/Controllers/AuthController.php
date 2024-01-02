<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function dashboard(): View
    {
        $judulHalaman = 'dashboard';
        return view('dashboard', compact('judulHalaman'));
    }
}
