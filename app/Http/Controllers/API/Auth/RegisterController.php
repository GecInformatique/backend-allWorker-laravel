<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Helpers\JsonResponse;
use App\Models\CandidatesHasCompetence;
use App\Models\Specialism;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends AppBaseController
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @OA\Post(
     *      path="/auth/register",
     *      summary="register",
     *      tags={"Auth"},
     *      description="register to app allworker",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Candidate")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Candidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(),Candidate::$rules);

        $birthDate = $request->day_birth;
        $birthDateTime = new DateTime($birthDate);
        $currentDateTime = new DateTime();
        // Calculer la différence entre les deux dates
        $ageDifference = $currentDateTime->diff($birthDateTime);

        // Vérifier si la différence en années est inferieur ou égale à 18
        if (!($ageDifference->y >= 18)) {
            return response()->json(new JsonResponse([],"Vous n'avez par âge règlementaire (18 ans) pour utiliser cette plate-forme.",false), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($validated->fails()) {
            return response()->json(new JsonResponse([],$validated->errors(),false), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $passwordGenerate = Str::random(10);

        $candidate = $this->create($request->all(),$passwordGenerate);

        $listIdCompetences = $request->competences;

        foreach ($listIdCompetences as $competenceId) {
            CandidatesHasCompetence::create([
                'candidates_id' => $candidate->id,
                'competences_id' => $competenceId
            ]);
        }

        $nameApp = env("APP_NAME" );

        Mail::send('confirm-register-email', [
            'email' => $request->email,
            'password' => $passwordGenerate,
            'name' => $request->first_name ." ".$request->last_name
        ],
            function($message) use($nameApp, $request){
                $message->to($request->email);
                $message->subject("Votre compte a étè enregistré chez ". $nameApp);
            });

        return response()->json((new JsonResponse([],
            "Your registered successfully.",
            true
        )), Response::HTTP_CREATED);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create($data,$password)
    {
        return Candidate::create([
            //'qr_code'=> $data['qr_code'],
            'enable'=> 1,
            'is_partner'=> $data['is_partner'],
            'published_online'=> 0,
            'profile_update'=> 1,
            'profile_verify_by_admin'=> 0,
            'profile_certificate'=> 0,
            //'my_logo'=> $data['my_logo'],
            //'picture'=> $data['picture'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'full_name'=> $data['full_name'],
            'owner_name'=> $data['owner_name'],
            'pseudo'=> $data['pseudo'],
            'phone_number'=> $data['phone_number'],
            'gender'=> $data['gender'],
            'day_birth'=> $data['day_birth'],
            //'post_box'=> $data['post_box'],
            //'rating'=> $data['rating'],
            'date_start_experience'=> $data['date_start_experience'],
            'current_salary'=> $data['current_salary'],
            'city'=> $data['city'],
            'complete_address'=> $data['complete_address'],
            //'nationality'=> $data['nationality'],
            //'longitude'=> $data['longitude'],
            //'latitude'=> $data['latitude'],
            'status_user'=> 'pending',
            'status_receiver_notification_job'=> 0,
            //'website'=> $data['website'],
            //'overview'=> $data['overview'],
            //'link_google'=> $data['link_google'],
            //'link_twitter'=> $data['link_twitter'],
            //'link_facebook'=> $data['link_facebook'],
            //'link_linkedin'=> $data['link_linkedin'],
            //'link_instagram'=> $data['link_instagram'],
            'group_id' => $data['group_id'],
            'specialisms_id' => $data['specialisms_id'],
        ]);
    }


}
