<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Helpers\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordController extends AppBaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function recover(Request $request)
    {
        $link = env("APP_URL_UNIVERSAL", "http://127.0.0.1:8000");

        $user = Candidate::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(new JsonResponse([],
                "Your email address was not found.",
                false
            ),  Response::HTTP_UNAUTHORIZED);
        }

        try {

            $token = Str::random(64);


           Candidate::where('email', $request->email)->update(['remember_token' => $token]);

            Mail::send('contact-verify-email',
                ['token' => $token,'link' => $link."/accounts/reset-password/"],
                function($message) use($request){
                $message->to($request->email);
                $message->subject('Your Password Reset Link');
            });

        } catch (\Exception $e) {
            return response()->json(new JsonResponse([],
                $e->getMessage(),
                false
            ),  Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(new JsonResponse([],
            'A reset email has been sent! Please check your email.',
            true
        ),  Response::HTTP_OK);
    }


}
