<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
//use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $request->validated();

        if (! $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
            ])){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function register(UserRegisterRequest $request){
        
        $request->validated();
      
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => isset($request->avatar) ? $request->avatar->store('avatars') : null,
            'password' =>  bcrypt($request->password)
        ]);

        //login & return token
        if(!($token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) && $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}