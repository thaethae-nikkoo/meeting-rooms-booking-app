<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::user()) {
            return redirect(url('/administrations/dashboard'));
        } else {
            return view('frontend.login');
        }
    }
    public function checkLogin(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/administrations/dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid User email or password.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/administrations'));
    }
}
