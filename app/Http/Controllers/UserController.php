<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthTrait;
use Illuminate\Support\Facades\Log;
use App\Notifications\VerificationCodeNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class UserController extends Controller
{

    use AuthTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'           =>'required|string|max:60|min:3',
            'phone_number'   =>'required|digits_between:11,18|unique:users',
            'password'       =>'required|string|min:8|confirmed',
        ]);

        $user   = User::create([
             'name'=>$request['name'],
             'phone_number'=>$request['phone_number'],
             'password'=>bcrypt($request['password']),
             'verification_code' => $this->generateUserVerCode()
        ]);

         // Log the verification code
        Log::info('Verification code for user '.$user->name.': '.$user->verification_code);

        return response()->json([
           'message'=>'User created successfully',
           'ver_code'=>$user->verification_code,
           'token'=>$user->createToken($request->name)->plainTextToken,
           'data'=>$user,''
        ],201);

    }


}
