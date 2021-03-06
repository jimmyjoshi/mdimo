<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;

class AuthenticateController extends Controller
{
    /**
     * Authenticate User.
     *
     * @param Request $request
     * @return json
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = Auth::user();

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token', 'user'));
    }
}
