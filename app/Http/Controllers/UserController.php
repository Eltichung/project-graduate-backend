<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loginUser(Request $request){
        $data = $request->only(['email', 'password']);
        $validator = User::validate($data);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ],401);
        }

        if(!Auth::attempt($data)){
            return response()->json([
                    'message' => 'An account failed to log on.'
                    , 401]
            );
        }
        $user=User::where('email',$request->email)->first();
        $user->tokens()->delete();
        return response()->json([
                'message' => 'login successful',
                'token'=> $user->createToken("Header")->plainTextToken
                , 201]
        );
    }
}
