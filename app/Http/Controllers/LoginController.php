<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('backend.login');
    }

    public function postLogin(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = array(
            'email' => $request['email'],
            'password' => $request['password'],
        );

        if (Auth::guard('web')->attempt($credentials)) {
            if (Auth::user()->status == 1) {
                return redirect()->route('admin.dashboard');
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

    public function user() {
        $user = Auth::user();
        $provinsis = Provinsi::all();

        return response()->json([
            'user' => $user,
            'provinsis' => $provinsis,
        ]);
    }

    public function updateProvinsi(Request $request) {
        try {
            $user = User::find(Auth::user()->id);
            $user->update([
                'provinsi_id' => $request['provinsi_id'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
