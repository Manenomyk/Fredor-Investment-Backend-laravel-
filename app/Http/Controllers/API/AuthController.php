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
                'errors' => $validator->messages()
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials',
                ]);
            } else {
                // if ($user->designition == 1) {
                //     $role = 'clerk';
                //     $token = $user->createToken($user->email . '_ClerkToken'['server:clerk'],)->plainTextToken;
                // } else if ($user->designition == 2) {
                //     $role = 'autho';
                //     $token = $user->createToken($user->email . '_authoToken', ['server:autho'])->plainTextToken;
                // } else {
                //     $role = 'admin';
                //     $token = $user->createToken($user->email . '_adminToken', ['server:admin'])->plainTextToken;
                // }
                $token = $user->createToken($user->email . '_Token')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'userID' => $user->id,
                    'role' => $user->designition,
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
            'status' => 200,
            'massage' => 'Logged out successfully',
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'id_number' => 'required',
            'location' => 'required',
            'designition' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()->all(),
            ], 422);
        } else {
            $users = new user;
            $users->name = $request->input('name');
            $users->email = $request->input('email');
            $users->phone_number = $request->input('phone_number');
            $users->id_number = $request->input('id_number');
            $users->location = $request->input('location');
            $users->designition = $request->input('designition');
            $users->password = Hash::make($request->input('id_number'));
            $users->save();
            return response([
                'status' => 200,
                'message' => 'New user created successfully',
            ]);
        }
    }

    public function index()
    {
        $users = user::all();
        return response()->json([
            'status' => 200,
            'viewusers' => $users,
        ]);
    }

    public function edit($id)
    {
        $profile = user::find($id);
        if ($profile) {
            return response()->json([
                'status' => 200,
                'profile' => $profile,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'id_number' => 'required',
            'location' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()->all(),
            ], 422);
        } else {
            $users = user::find($id);
            if ($users) {
                $users->name = $request->input('name');
                $users->email = $request->input('email');
                $users->phone_number = $request->input('phone_number');
                $users->id_number = $request->input('id_number');
                $users->location = $request->input('location');

                $users->save();
                return response([
                    'status' => 200,
                    'message' => 'Profile updated successfully',
                ]);
            } else {
                return response([
                    'status' => 404,
                    'message' => 'User ID not found',
                ]);
            }
        }
    }
}
