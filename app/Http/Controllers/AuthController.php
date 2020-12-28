<?php

namespace App\Http\Controllers;

use DB;
use Str;
use Mail;
use Carbon;
use App\User;
use App\Mail\PasswordReset;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\RecoveryPassRequest;
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
        //$this->middleware('auth:api', ['except' => ['login','register','recovery']]);
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

    
    public function recovery(RecoveryPassRequest $request){
        $user = User::firstWhere('email','josip.suvak04@gmail.com');

        /* docs
        $status = Password::sendResetLink(
            $request->only('email')
        );
        */


        if($user){
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(60),
                'created_at' => Carbon::now()
            ]);
            $data = DB::table('password_resets')->where('email', $request->email)->first();
            Mail::to($request->email)->send(new PasswordReset($data->token));
        }
        
        /*
        Mail::raw('It works!',function($message){
            $message->from(config('admin.admin_email'))
                    ->to('email@example.com')
                    ->subject('Recovery password request');
        });
        */
     
        return response()->json([
            'message' => 'Email sent!'
        ]);
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