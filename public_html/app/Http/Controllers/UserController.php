<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user",
     *     operationId="/user/",
     *     tags={"MongoDB User"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *     ),
     * )
     * 
     */

    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' => true,
            'message' => 'success get data user',
            'data' => $user
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/user/{id}",
     *      operationId="getUserById",
     *      tags={"MongoDB User"},
     *      summary="Get user information",
     *      description="Returns user data",
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
     *      )
     * )
     */

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

    /**
     * @OA\Put(
     *      path="/user/{id}",
     *      operationId="updateUsert",
     *      tags={"MongoDB User"},
     *      summary="Update existing user",
     *      description="Returns updated user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="phone",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="job",
     *                  type="string",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
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

    /**
     * @OA\Delete(
     *      path="/user/{id}",
     *      operationId="deleteUser",
     *      tags={"MongoDB User"},
     *      summary="Delete existing user",
     *      description="Deletes a record and returns no content",
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
