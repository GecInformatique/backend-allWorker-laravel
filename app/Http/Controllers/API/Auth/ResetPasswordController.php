<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Helpers\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends AppBaseController
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Reset the given user's password.
     *
     * @param Request $request
     */
    public function reset(Request $request,$token)
    {
        $request->validate([
            'email' => 'required|email|exists:candidates',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'same:password',
        ]);


        $updatePassword = Candidate::where('email', $request->email)->where('remember_token' , $token)->first();

        if(!$updatePassword){
            return response()->json(new JsonResponse([],
                'Invalid token!',
                false
            ),  Response::HTTP_UNAUTHORIZED);
        }

        $candidate = Candidate::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'remember_token' => ""
            ]);

        return response()->json(new JsonResponse($candidate,
            'Your password has been changed!',
            true
        ),  Response::HTTP_ACCEPTED);

    }


    /**
     * Reset the given user's password.
     *
     * @param Request $request
     */
    public function generateNewPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:candidates',
        ]);

        $candidate = Candidate::where('email', $request->email)->first();

        $passwordGenerate = Str::random(10);

        $nameApp = env("APP_NAME" );

        Candidate::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        Mail::send('confirm-register-email', [
            'email' => $request->email,
            'password' => $passwordGenerate,
            'name' => $candidate->first_name ." ".$candidate->last_name
        ], function($message) use($nameApp, $request){
                $message->to($request->email);
                $message->subject("Votre mot de passe de connexion chez ". $nameApp);
            });

        return response()->json(new JsonResponse($candidate,
            'Your password has been changed!',
            true
        ),  Response::HTTP_ACCEPTED);

    }
}
