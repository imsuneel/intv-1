<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['data'=>['status'=>true]];
});

Route::get('/login', function () {
    return response()->json(['error' => 'Unauthenticated.'])->setStatusCode(401);
})->name('login');

