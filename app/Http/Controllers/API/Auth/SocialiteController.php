<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\OauthProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends AppBaseController
{
    // Les tableaux des providers autorisés
    protected $providers = [ "google", "github", "facebook" ];

    # La vue pour les liens vers les providers
    public function loginRegister () {
        return view("socialite.login-register");
    }

    # redirection vers le provider
    public function redirect (Request $request) {

        $provider = $request->provider;

        // On vérifie si le provider est autorisé
        if (in_array($provider, $this->providers)) {
            return Socialite::driver($provider)->redirect(); // On redirige vers le provider
        }
        abort(404); // Si le provider n'est pas autorisé
    }

    /**
     * Obtain the user information from the provider.
     */
    public function callback (Request $request) {

        $provider = $request->provider;

        if (in_array($provider, $this->providers)) {

            // Les informations provenant du provider
            $data = Socialite::driver($request->provider)->user();

            // Les informations de l'utilisateur
            $user = $data->user;

            // voir les informations de l'utilisateur
            $user = $this->findOrCreateUser($provider, $user);

            $this->guard()->setToken(
                $token = $this->guard()->login($user)
            );

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearerToken',
                'expires_in' => $this->guard()->factory()->getTTL() * 60
            ]);
        }
        abort(404);
    }


    /**
     * Find or create a user.
     * @param string $provider
     * @param SocialiteUser $user
     * @return
     */
    protected function findOrCreateUser(string $provider, SocialiteUser $user)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]);

            return $oauthProvider->user;
        }

        if (Candidate::where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException;
        }

        return $this->createUser($provider, $user);
    }

    /**
     * Create a new user.
     * @param string $provider
     * @param SocialiteUser $sUser
     * @return
     */
    protected function createUser(string $provider, SocialiteUser $sUser)
    {
        $user = Candidate::create([
            'name' => $sUser->getName(),
            'email' => $sUser->getEmail(),
            'email_verified_at' => now(),
            'enable' => 1,
            'status_user' => 1,
            'is_online' => 1,
            'is_admin' => 0,
            'profile_verify' => 0,
            'gender' => 1,
            'nationality' => "Camerounais",
            'country' => "Cameroun",
            //'roles_id' => $data['role'],
        ]);

        $user->oauthProviders()->create([
            'provider' => $provider,
            'candidates_id' => $user->getId(),
            'provider_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }
}
