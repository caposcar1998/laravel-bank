<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {
        \Log::info("Este es  mi mensaje");
        $account = \App\Models\Account::find(1);
        return view('homepage.index', ['account' => $account]);
    }
}
