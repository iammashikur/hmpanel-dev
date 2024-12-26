<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    echo 'test';
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
