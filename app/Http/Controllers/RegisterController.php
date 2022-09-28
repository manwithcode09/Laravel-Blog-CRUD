<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller {

    public function create () {

        return view('register.create', [

            'title' => 'Register',
            'active' => 'register'

        ]);
    }


    public function store (Request $request) {

       //proses validasi
       $validatedData = $request->validate([

            'name' => 'required|max:255',
            'username' => ['required', 'min:5', 'max:255', 'unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
       ]);

       //Hashing password
       $validatedData['password'] = Hash::make($validatedData['password']);
       
       //masukan data ke database (tabel user)
       User::create($validatedData);

       //membuat flash message ketika register berhasil
       //$request->session()->flash('success', 'Your account created successfully!');

       //cara simple ; redirect sambil membawa session success
       return redirect('/login')->with('success', 'successfully!');

    }

}
