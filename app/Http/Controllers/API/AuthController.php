<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email|string',
            'password' => 'min:6|string|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()->all()
            ], 422);
        }
         else {
            $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'password' =>Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' =>$token,
                'message' => 'Registered successfully',
            ]);
        }
    }
}
