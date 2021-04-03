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

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Login",
     *      description="Login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="email@gmail.com",
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="min 8 char",
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
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

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

    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"Auth"},
     *      summary="Register User",
     *      description="Register User",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  description="superman dan spiderman",
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="email@gmail.com",
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="min 8 char",
     *              ),
     *              @OA\Property(
     *                  property="phone",
     *                  type="string",
     *                  description="081234567890 - nullable",
     *              ),
     *              @OA\Property(
     *                  property="job",
     *                  type="string",
     *                  description="software engineer - nullable",
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
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

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

    /**
     * @OA\Get(
     *     path="/logout",
     *     operationId="/logout/",
     *     tags={"Auth"},
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
     * )
     * 
     */

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
