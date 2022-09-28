<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function index(){

        return view('login.index', [


            'title' => 'Login',
            'active' => 'login'
        ]);

    }

    public function authenticate(Request $request) {

        //validasi email dan password
        $credentials = $request->validate([

            'email' => 'required|email:dns',
            'password' => 'required'

        ]);

        // cek percobaan authentikasi dari credentials
        if(Auth::attempt($credentials)) {

            //jika berhasil, maka generate session baru
            $request->session()->regenerate();
            
            //lalu redirect ke halaman dashboard, dengan melewati middleware (intended)
            return redirect()->intended('/dashboard');

        }

        //dan jika proses authentikasi login gagal, maka kembali ke halaman login sambil kirim pesan error
        return back()->with('loginError', 'Login failed!');

    }


    public function logout(Request $request) {

        Auth::logout();

        // generate session baru
        $request->session()->invalidate();

        // Regenerate the CSRF token value.
        $request->session()->regenerateToken();

        //redirect ke halaman home
        return redirect('/');

    }

}
