<?php

namespace App\Http\Controllers;

use App\Salary;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{

    /**
     * @OA\Get(
     *     path="/salary",
     *     operationId="/salary/",
     *     tags={"MongoDB Salary"},
     *     security={{"token": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * 
     */

    public function index()
    {
        $salary = Salary::all();
        return response()->json([
            'status' => true,
            'message' => 'success get data salary',
            'data' => $salary
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/salary/{id}",
     *      operationId="getSalaryById",
     *      tags={"MongoDB Salary"},
     *      summary="Get salary information",
     *      description="Returns salary data",
     *      security={{"token": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Salary id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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

    /**
     * @OA\Get(
     *      path="/salary-user/{id}",
     *      operationId="getSalaryByUserId",
     *      tags={"MongoDB Salary"},
     *      summary="Get salary by user id information",
     *      description="Returns salary data",
     *      security={{"token": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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

    /**
     * @OA\Post(
     *      path="/salary",
     *      operationId="create salary",
     *      tags={"MongoDB Salary"},
     *      summary="Create Salary",
     *      description="Create Salary",
     *      security={{"token": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  description="5645565s4d0sd4546654",
     *              ),
     *              @OA\Property(
     *                  property="salary",
     *                  type="integer",
     *                  description="7000000",
     *              ),
     *              @OA\Property(
     *                  property="date",
     *                  type="date",
     *                  description="2021-03-30",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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

    /**
     * @OA\Put(
     *      path="/salary/{id}",
     *      operationId="salary id",
     *      tags={"MongoDB Salary"},
     *      summary="Update Salary",
     *      description="Update Salary",
     *      security={{"token": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  description="5645565s4d0sd4546654",
     *              ),
     *              @OA\Property(
     *                  property="salary",
     *                  type="integer",
     *                  description="7000000",
     *              ),
     *              @OA\Property(
     *                  property="date",
     *                  type="date",
     *                  description="2021-03-30",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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

    /**
     * @OA\Delete(
     *      path="/Salary/{id}",
     *      operationId="deleteSalary",
     *      tags={"MongoDB Salary"},
     *      summary="Delete existing salary data",
     *      description="Deletes a record and returns no content",
     *      security={{"token": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Salary id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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