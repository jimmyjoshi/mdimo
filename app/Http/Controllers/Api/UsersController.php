<?php

namespace App\Http\Controllers\Api;

use Auth;
use Response;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Transformers\UserTransformer;

class UsersController extends BaseApiController
{
    protected $userTransformer;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->userTransformer = new UserTransformer;
    }

    /**
     * Login request.
     *
     * @param Request $request
     * @return type
     */
    public function login(Request $request)
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

        $user = Auth::user()->toArray();

        $userData = array_merge($user, ['token' => $token]);

        $responseData = $this->userTransformer->transform((object) $userData);

        // if no errors are encountered we can return a JWT
        return $this->successResponse($responseData);
    }

    /**
     * Login With Phone
     *
     * @param Request $request
     * @return type
     */
    public function loginWithPhone(Request $request)
    {
        if($request->has('phone') && $request->get('phone'))
        {
            $user = User::where('phone', $request->get('phone'))->first();

            if(isset($user) && isset($user->id))
            {
                $token          = JWTAuth::fromUser($user);
                $userData       = array_merge($user->toArray(), ['token' => $token]);
                $responseData   = $this->userTransformer->transform((object) $userData);
                
                return $this->successResponse($responseData);
            }
        }

        return $this->failureResponse([
            'message' => 'No user found for given Phone Number',
        ], 'No User Found!');
    }

    /**
     * Logout request.
     * @param  Request $request
     * @return json
     */
    public function logout(Request $request)
    {
        $userId = $request->header('UserId');
        $userToken = $request->header('UserToken');
        $response = $this->users->deleteUserToken($userId, $userToken);
        if ($response) {
            return $this->ApiSuccessResponse([]);
        } else {
            return $this->respondInternalError('Error in Logout');
        }
    }
}
