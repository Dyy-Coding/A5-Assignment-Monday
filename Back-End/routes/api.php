<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\MembersController;
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

Route::prefix("members")->group(function () {
    Route::get("/", [MembersController::class, "index"]);
    Route::post("/create", [MembersController::class, "create"]);
});

Route::prefix("authors")->group(function () {
    Route::get("/", [AuthorController::class, "index"]);
    Route::post("/create", [AuthorController::class, "create"]);
    Route::get("/show/{id}", [AuthorController::class, "show"]);
    Route::put("/update/{id}", [AuthorController::class, "update"]);
    Route::delete("/delete/{id}", [AuthorController::class, "destroy"]);
});



// 🔐 User info for authenticated users via Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
