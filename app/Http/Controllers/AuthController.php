<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
