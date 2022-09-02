<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* Creating a route for the login page. */
Route::post('/login', [AuthController::class, 'Login']);
/* Creating a route for the register page. */
Route::post('/register', [AuthController::class, 'Register']);
/* This is a route for the forget password page. */
Route::post('/forgetpassword', [ForgetController::class, 'ForgetPassword']);
/* This is a route for the reset password page. */
Route::post('/resetpassword', [ResetController::class, 'ResetPassword']);
/* This is a route for the user page. */
/* A middleware that is used to check if the user is authenticated or not. */
Route::get('/user', [UserController::class, 'User'])->middleware('auth:api');
