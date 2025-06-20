<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|--------------------------------------------------------------------------
*/





// 🔐 User info for authenticated users via Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
