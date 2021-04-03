<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' => true,
            'message' => 'success get data user',
            'data' => $user
        ], 200);
    }

    public function get($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'user data not found'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'success get data user',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $validation = Validator::make($request->all(), [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255'],
            'password' => ['string', 'min:8'],
            'phone' => ['string'],
            'job' => ['string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'user data not found'
            ], 400);
        }

        $data = $request->all();
        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'success update data user',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'user data not found'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'success delete user',
        ], 200);
    }
}
