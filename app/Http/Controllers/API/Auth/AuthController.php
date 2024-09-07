<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class AuthController extends AppBaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Sign in user",
     *      description="Returns the user token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="token",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(new JsonResponse([],  $validator->errors(),false), Response::HTTP_UNAUTHORIZED);
        }

        $credentials = $request->only(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return response()->json(new JsonResponse([], 'Login error credentials!!!'),
                Response::HTTP_UNAUTHORIZED);
        }

        $user = Candidate::where('email', $request->email)->first();


        $token = Auth::login($user);
        return $this->respondWithToken($token);

        // j ai commenté cette partie car le mot de passe et envoyer par email apres la
        // creation du compte cad une verification de email
        /*if(!$user->email_verified_at) {

            return response()->json((new JsonResponse(
                [
                    "status"=>"UNACTIVATED"
                ],
                "Your e-mail can not verified. You can't login.",
                false
            )), Response::HTTP_UNAUTHORIZED);

        } else {
            $token = Auth::login($user);

            return $this->respondWithToken($token);

        }*/

    }


    /**
     *
     * @OA\Get(
     *      path="/auth/me",
     *      operationId="user",
     *      tags={"Auth"},
     *      summary="Sign in user",
     *      description="Returns the user",
     *      security={ {"bearerToken": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function me()
    {
        try {

            if (! $user =  Auth::guard()->authenticate()) {
                return response()->json(new JsonResponse('',
                    "user_not_found",
                    false
                ), Response::HTTP_NOT_FOUND);
            }else{

                return response()->json(new JsonResponse($user,
                    "User retrieved successfully.",
                    true
                ), Response::HTTP_OK);

            }

        } catch (TokenExpiredException $e) {
            return response()->json(new JsonResponse(
                $e->getCode(),
                "token_expired",
                false
            ), Response::HTTP_BAD_REQUEST);
        } catch (TokenInvalidException $e) {
            return response()->json(new JsonResponse(
                $e->getCode(),
                "token_invalid",
                false
            ), Response::HTTP_BAD_REQUEST);
        } catch (JWTException $e) {
            return response()->json(new JsonResponse(
                $e->getCode(),
                "token_absent",
                false
            ), Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @OA\Post(
     * path="/auth/logout",
     * summary="Logout",
     * description="Logout user and invalidate token",
     * operationId="authLogout",
     * tags={"Auth"},
     * security={ {"bearerToken": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json((new JsonResponse(
            [],
            "Logout successfully.",
            true
        )), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/auth/refresh",
     *      operationId="Refresh",
     *      tags={"Auth"},
     *      summary="Refresh token",
     *      description="Returns the refresh token",
     *      security={ {"bearerToken": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function refresh()
    {
        $token =  Auth::refresh();
        return $this->respondWithToken($token);

    }

    /**
     * @OA\Post(
     *      path="/auth/change-password",
     *      operationId="change-password",
     *      tags={"Auth"},
     *      summary="Change password",
     *      security={ {"bearerToken": {} }},
     *      description="Returns the status of the password update",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"oldpassword", "newpassword"},
     *              @OA\Property(
     *                  property="oldpassword",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="newpassword",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="status",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

/*
    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(new JsonResponse([],  $validator->errors(), false), Response::HTTP_UNAUTHORIZED);
    }

    $credentials = $request->only(['email', 'password']);

    // Recherche dans la table Candidate
    $candidate = Candidate::where('email', $request->email)->first();

    if ($candidate) {
        // Essai d'authentification avec Candidate
        if (Auth::attempt($credentials)) {
            $token = Auth::login($candidate);
            return $this->respondWithToken($token);
        } else {
            return response()->json(new JsonResponse([], 'Login error credentials!!!'), Response::HTTP_UNAUTHORIZED);
        }
    } else {
        // Sinon, essayer avec la table User
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = Auth::login($user);
            return $this->respondWithToken($token);
        } else {
            return response()->json(new JsonResponse([], 'Login error credentials!!!'), Response::HTTP_UNAUTHORIZED);
        }
    }
}*/


}


