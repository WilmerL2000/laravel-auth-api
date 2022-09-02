<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetController extends Controller
{
    public function ForgetPassword(ForgetRequest $request)
    {
        $email = $request->email;

        /* Checking if the email exists in the database. */
        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'Email invalid'
            ], 401);
        }

        $token = rand(10, 100000);

        try {
            /* Inserting the email and token into the password_resets table. */
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            /* Sending an email to the user with the token. 
            Envia el token a la clase y esa clase envia el email*/
            Mail::to($email)->send(new ForgetMail($token));

            return response([
                'message' => 'Reset Password Mail to your email'
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
