<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\ToolsTrait;
use App\Models\User;

trait AuthTrait{
    
  

    public function login(Request $request)
    {
        $request->validate([
        	                'phone_number'=>'required|digits_between:11,18|exists:users',
                            'password'=>'required'
                           ]);
        
        $credentials = request(['phone_number', 'password']);

         $user = User::where('phone_number', $request->phone_number)->first();
        
        if(!$user || !Hash::check($request->password, $user->password))
        {
              return response()->json(['message'=>'Unauthorized'],401);
        }

         if (!$user->is_verified)
         {
            return response()->json(['message' => 'Account not verified'], 403);
         }

         $token = $user->createToken($user->name)->plainTextToken;


       return response()->json([
           'message'=>'logged in done successfully',
           'token'=>$token,
           'data'=>$user
        ],201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    

    public function VerifyUserCode(Request $request)
    {
     $request->validate([
         'phone_number'=>'required|digits_between:11,18|exists:users',
        'verification_code' => 'required|integer|digits:6',
    ]);

    $user = User::where('phone_number', $request->phone_number)->first();

    if (!$user || $user->verification_code != $request->verification_code) {
        return response()->json(['message' => 'Invalid verification code'], 400);
    }

     $user->update(['is_verified' => 1, 'verification_code' => null]);

    return response()->json(['message' => 'Account verified successfully']);
       
    }

    protected function generateUserVerCode()
    {
          return random_int(100000, 999999);
    }

}