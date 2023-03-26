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
        } else {
            $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' => $token,
                'message' => 'Registered successfully',
            ]);
        }
    }


    public function login(request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all()
            ], 422);
        } else {
            $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials',
                ]);
            } else {
                $token = $user->createToken($user->email . '_Token')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'token' => $token,
                    'message' => 'logged in successfully',
                ]);
            }
        };
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'massage' =>'Logged out successfully',
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'phone_number'=> 'required',
            'id_number' => 'required',
            'location' => 'required',
            'designition' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()->all(),
            ], 422);
        }else {
            $users= new user;
            $users -> name = $request->input('name');
            $users -> email = $request->input('email');
            $users -> phone_number = $request->input('phone_number');
            $users -> id_number = $request->input('id_number');
            $users -> location = $request->input('location');
            $users -> roles = $request->input('designition');
            $users -> password = Hash::make($request->input('id_number'));
            $users->save();
            return response([
                'status' => 200,
                'message' => 'New user created successfully',
            ]);

        }
    }
}
