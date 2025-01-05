<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('login');
    }

    public function postLogin(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        dd($request);

        $credentials = array(
            'email' => $request['email'],
            'password' => $request['password'],
        );

        if (Auth::guard('web')->attempt($credentials)) {
            if (Auth::user()->status == 1) {
                return redirect()->route('penyisihan.dashboard');
            }

            Auth::guard('web')->logout();
            
            return redirect()->route('login')->with('error', 'Status tidak aktif.');
        }
        
        return redirect()->route('login')->with('error', 'Email dan password salah.');
    }

    public function logout() {
        Auth::guard('web')->logout();

        return redirect()->route('login');
    }
}
