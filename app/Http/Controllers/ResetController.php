<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    public function ResetPassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);

        /* Checking if the email exists in the password_resets table. */
        $emailcheck = DB::table('password_resets')->where('email', $email)->first();
        /* Checking if the token exists in the password_resets table. */
        $pincheck = DB::table('password_resets')->where('token', $token)->first();

        /* Checking if the email exists in the password_resets table. */
        if (!$emailcheck) {
            return response([
                'message' => 'Email not found'
            ], 401);
        }

        /* Checking if the pin code is valid. */
        if (!$pincheck) {
            return response([
                'message' => 'Pin Code Invalid'
            ], 401);
        }

        /* Updating the password in the database. */
        DB::table('users')->where('email', $email)->update(['password' => $password]);
        /* Deleting the token from the password_resets table. */
        DB::table('password_resets')->where('email', $email)->delete();

        return response([
            'message' => 'Password Reset Successfully'
        ]);
    }
}
