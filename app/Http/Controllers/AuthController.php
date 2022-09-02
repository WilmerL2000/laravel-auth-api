<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * > The function checks if the user is authenticated, if the user is authenticated, it creates a
     * token for the user and returns the token and the user
     * 
     * @param Request request This is the request object that contains the email and password.
     */
    public function Login(Request $request)
    {
        try {
            /* Checking if the user is authenticated. */
            if (Auth::attempt($request->only('email', 'password'))) {
                /* Getting the user that is currently logged in. */
                $user2 = Auth::user();
                /* Getting the user that is currently logged in. */
                $user = User::find($user2->id);
                $token = $user->createToken('app')->accessToken;

                return response([
                    'message' => "Successfully Login",
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }

        return response([
            'message' => 'Invalid Email or Password',
        ], 401);
    }

    /**
     * It creates a user, creates a token for the user, and returns the token and user
     * 
     * @param RegisterRequest request The request object.
     */
    public function Register(RegisterRequest $request)
    {
        try {
            /* Creating a user. */
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            /* Creating a token for the user. */
            $token = $user->createToken('app')->accessToken;

            return response([
                'message' => 'Successfully Register',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
