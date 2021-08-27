<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    Route::get('accounts', 'AccountsController@index')
        ->name('accounts.index');
    Route::get('accounts/create', 'AccountsController@create')
        ->name('accounts.create');
    Route::post('accounts', 'AccountsController@store')
        ->name('accounts.store');
    Route::get('/', 'DashboardController@index')
        ->name('dashboard.index');
});
