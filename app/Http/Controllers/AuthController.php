<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $req)
    {
        return view('auth.register');
    }

    /**
     * Save the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUser(Request $req)
    {
        $data = $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect()->route('homepage');
    }
}
