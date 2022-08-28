<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|max:50|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully registered',
            'data' => $user
        ]);
    }

    public function authenticate(Request $request)
    {
        $data = $request->only('email', 'password');
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try {
            if (!$token = JWTAuth::attempt($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return $validator->validated();
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
                'data' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'User successfully logged in',
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try {
            JWTAuth::invalidate($validator->validated()['token']);
            return response()->json([
                'success' => true,
                'message' => 'User successfully logged out.'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out.',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    public function get_user(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user = JWTAuth::authenticate($validator->validated()['token']);
        return response()->json([
            'success' => true,
            'message' => 'success get user data',
            'data' => $user,
        ]);
    }

    public function update_user(Request $request, $id)
    {
        $data = $request->only('name', 'email', 'password', 'new_password', 'password_confirmation');
        $validator = Validator::make($data, [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email,' . $id,
            'password' => 'required|string',
            'new_password' => 'required|string|min:8|max:50|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user = User::find($id);
        if ($user) {
            if (password_verify($validator->validated()['password'], $user->password)) {
                $user->name = $validator->validated()['name'];
                $user->email = $validator->validated()['email'];
                $user->password = bcrypt($validator->validated()['new_password']);
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'User successfully updated',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password is incorrect',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }
    }
}
