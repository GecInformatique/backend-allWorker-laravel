<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class VerificationController extends AppBaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }



    public function verify($token)
    {

        $user = Candidate::where('remember_token', $token)->first();

        if(!is_null($user) ){

            if(!$user->email_verified_at) {

                $user->email_verified_at = new DateTime();
                $user->remember_token = "";
                $user->save();

                return response()->json((new JsonResponse([],
                    "Your e-mail is verified. You can now login.",
                    true
                )), Response::HTTP_OK);

            } else {

                return response()->json((new JsonResponse([],
                    "Your e-mail is already verified. You can now login.",
                    false
                )), Response:: HTTP_UNAUTHORIZED);

            }
        }else {

            return response()->json((new JsonResponse([],
                'Sorry your email cannot be identified.',
                false
            )), Response::HTTP_UNAUTHORIZED);

        }
    }


    public function resend(Request $request)
    {
        $link = env("APP_URL_UNIVERSAL", "http://127.0.0.1:8000");

        $this->validate($request, ['email' => 'required|email']);

        $user = Candidate::where('email', $request->email)->first();

        if(!is_null($user) ){

            if(!$user->email_verified_at) {

                $token = Str::random(64);

                $user->remember_token = $token;
                $user->save();

                Mail::send('contact-verify-email',
                    ['token' => $token,'link' => $link."/auth/email/verify-email/"],
                    function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });

                return response()->json((new JsonResponse([],
                    "The new email has been sent",
                    false
                )), Response::HTTP_UNAUTHORIZED);

            } else {

                return response()->json((new JsonResponse([],
                    "Your e-mail is already verified. You can now login.",
                    true
                )), Response::HTTP_OK);

            }

        }else {

            return response()->json((new JsonResponse([],
                'Sorry your email cannot be identified.',
                false
            )), Response::HTTP_UNAUTHORIZED);

        }
    }
}
