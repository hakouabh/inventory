<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;

class AuthController extends Controller
{
    
 /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    // 

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
         $validateData = $request->validate([
         'email' => 'required',
         'password' => 'required',
         
         ]);



        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password Invalid'], 401);
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
        return response()->json(Auth::check());
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



    public function register(Request $request){
     
     $validateData = $request->validate([
       'email' => 'required|unique:users|max:255',
       'name' => 'required',
       'password' => 'required|min:6|confirmed'

     ]);
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
        'latitude' => rand(35*10000,36*10000)/10000,
        'longitude' => -1*(rand(0,1*10000)/10000)
    ]);

     return $this->login($request);



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
        $user=Auth::user();
        return response()->json([
            'access_token' => $user->createToken('API')->accessToken,
            'token_type' => 'bearer',
            'expires_in' => 31536000,
            'name' => $user->name,
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }
}
 