<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Database;

class RankFirebaseController extends Controller
{

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @OA\Get(
     *     path="/rank-firebase",
     *     operationId="/rank-firebase/",
     *     tags={"Firebase Rank"},
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
        $database = app('firebase.database');
        $data = $database->getReference('ibid/rank/')->getSnapshot()->getValue();
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'data not found'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'success get data',
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/rank-firebase/{id}",
     *      operationId="getRankFirebaseById",
     *      tags={"Firebase Rank"},
     *      summary="Get rank information",
     *      description="Returns rank data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Rank id",
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
        $database = app('firebase.database');
        $data = $database->getReference('ibid/rank/'.$id)->getValue();
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'data not found'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'success get data',
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/rank-firebase",
     *      operationId="create rank-firebase",
     *      tags={"Firebase Rank"},
     *      summary="Create Rank",
     *      description="Create Rank",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  description="5645565s4d0sd4546654",
     *              ),
     *              @OA\Property(
     *                  property="attendance_point",
     *                  type="integer",
     *                  description="5",
     *              ),
     *              @OA\Property(
     *                  property="performance_point",
     *                  type="integer",
     *                  description="5",
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
            'attendance_point' => ['required', 'numeric'],
            'performance_point' => ['required', 'numeric'],
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

        $curTime = Carbon::now();
        $database = app('firebase.database');
        $reference = $database->getReference('ibid/rank/');
        $data = $reference->push([
                        'user_id' => $request->user_id,
                        'attendance_point' => $request->attendance_point,
                        'performance_point' => $request->performance_point,
                        'date' => $curTime->format('Y-m-d')
                    ]);

        return response()->json([
            'status' => true,
            'message' => 'success create data rank',
            'data' => $data->getValue()
        ], 200);
    }

    /**
     * @OA\Put(
     *      path="/rank-firebase/{id}",
     *      operationId="update rank firebase by id",
     *      tags={"Firebase Rank"},
     *      summary="Update Rank",
     *      description="Update Rank",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  description="5645565s4d0sd4546654",
     *              ),
     *              @OA\Property(
     *                  property="attendance_point",
     *                  type="integer",
     *                  description="5",
     *              ),
     *              @OA\Property(
     *                  property="performance_point",
     *                  type="integer",
     *                  description="5",
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
        $database = app('firebase.database');
        $reference = $database->getReference('ibid/rank/'.$id);
        $data = $reference->getValue();
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'data not found'
            ], 400);
        }

        // Validation
        $validation = Validator::make($request->all(), [
            'user_id' => ['required', 'string'],
            'attendance_point' => ['numeric'],
            'performance_point' => ['numeric'],
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

        $data_array = $request->all();

        $reference->update($data_array);

        return response()->json([
            'status' => true,
            'message' => 'success update data rank',
            'data' => $reference->getValue()
        ], 200);
    }

    /**
     * @OA\Delete(
     *      path="/rank-firebase/{id}",
     *      operationId="deleteRankFirebase",
     *      tags={"Firebase Rank"},
     *      summary="Delete existing rank data",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Rank id",
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
        $database = app('firebase.database');
        $check_remove = $database->getReference('ibid/rank/'.$id)->getValue();
        if (!$check_remove) {
            return response()->json([
                'status' => false,
                'message' => 'data not found'
            ], 400);
        }
        $database->getReference('ibid/rank/'.$id)->remove();
        return response()->json([
            'status' => true,
            'message' => 'success delete data rank'
        ], 200);
    }
}