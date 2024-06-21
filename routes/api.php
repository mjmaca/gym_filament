<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Member;
use App\Models\Expense;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth:sanctum')->group(function () {
    // Routes that require authentication
    Route::get('/member/{email}', function ($email) {
        return Member::where('email', $email)->first();
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});










