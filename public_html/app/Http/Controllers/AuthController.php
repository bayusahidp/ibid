<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['logout']]);
    }

    public function login(Request $request)
    {
        // Validation
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validation->errors()
            ], 400);
        }

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'your email or password is wrong'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'login success',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    public function register(Request $request)
    {
        // Validation
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['string'],
            'job' => ['string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validation->errors()
            ], 400);
        }

        // create data user
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        return response()->json([
            'status' => true,
            'message' => 'register success',
            'data' => $user
        ], 200);
    }

    public function logout()
    {
        // $auth = Auth::user();
        // if (!$auth) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unautorized'
        //     ], 401);
        // }
        
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'logout success'
        ], 200);
    }
}
