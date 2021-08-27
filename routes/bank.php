<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    Route::get('/', 'DashboardController@index')
        ->name('dashboard.index');
});
