<?php

namespace App\Http\Controllers;

use App\Salary;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    public function index()
    {
        $salary = Salary::all();
        return response()->json([
            'status' => true,
            'message' => 'success get data salary',
            'data' => $salary
        ], 200);
    }

    public function get($id)
    {
        $salary = Salary::find($id);
        if (!$salary) {
            return response()->json([
                'status' => false,
                'message' => 'salary data not found'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'success get data salary',
            'data' => $salary
        ], 200);
    }

    public function get_by_user($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'user data not found'
            ], 400);
        }

        $salary = Salary::where('user_id', $id)->get();
        return response()->json([
            'status' => true,
            'message' => 'success get data salary user',
            'data' => $salary
        ], 200);
    }

    public function store(Request $request)
    {
        // Validation
        $validation = Validator::make($request->all(), [
            'user_id' => ['required', 'string'],
            'salary' => ['required', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $user = User::find($request->user_id);
        if (!$user ) {
            return response()->json([
                'status' => false,
                'message' => 'invalid user'
            ], 400);
        }

        $data = $request->all();
        $salary = Salary::create($data);
        return response()->json([
            'status' => true,
            'message' => 'success create salary',
            'data' => $salary
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $salary = Salary::find($id);
        if (!$salary) {
            return response()->json([
                'status' => false,
                'message' => 'salary data not found'
            ], 400);
        }

        // Validation
        $validation = Validator::make($request->all(), [
            'user_id' => ['string'],
            'salary' => ['numeric'],
            'date' => ['date'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        $data = $request->all();
        $salary->update($data);

        return response()->json([
            'status' => true,
            'message' => 'success update data salary',
            'data' => $salary
        ], 200);
    }

    public function destroy($id)
    {
        $salary = Salary::find($id);
        if (!$salary) {
            return response()->json([
                'status' => false,
                'message' => 'salary data not found'
            ], 400);
        }

        $salary->delete();

        return response()->json([
            'status' => true,
            'message' => 'success delete salary',
        ], 200);
    }
}