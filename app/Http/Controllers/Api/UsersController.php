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
use Storage;
use File;

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

    /**
     * Update Profile.
     *
     * @param Request $request
     * @return string
     */
    public function updateProfile(Request $request)
    {
        $user = access()->user();

        if(isset($user->id))
        {
            if($request->has('name') && $request->get('name'))
            {
                $user->name = $request->get('name');
            }

            if($request->has('phone') && $request->get('phone'))
            {
                $user->phone = $request->get('phone');
            }

            if($request->has('email') && $request->get('email'))
            {
                $user->email = $request->get('email');
            }

            if($request->has('gender') && $request->get('gender'))
            {
                $user->gender = $request->get('gender');
            }

            if($request->has('birthdate') && $request->get('birthdate'))
            {
                $user->birthdate = date('Y-m-d', strtotime($request->get('birthdate')));
            }

            if($request->file('profile_pic'))
            {
                $uploadedFile   = $request->file('profile_pic'); 
                $filename       = time().$uploadedFile->getClientOriginalName();
                $filePath       = public_path() . '/img/user/';
                
                if($uploadedFile->move($filePath, $filename))
                {
                    $user->profile_pic = $filename;
                }
            }

            if($user->save())
            {
                $token          = JWTAuth::fromUser($user);
                $userData       = array_merge($user->toArray(), ['token' => $token]);
                $responseData   = $this->userTransformer->transform((object) $userData);
                return $this->successResponse($responseData, 'User updated Successfully');
            }
        }


        return $this->failureResponse([
            'reason' => 'Invalid Input, Please provide valid inputs',
        ], 'Something went wrong !');
    }
}
