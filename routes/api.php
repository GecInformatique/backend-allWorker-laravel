<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/generate-pw', function () {
    return Hash::make("allworkers");
});


/*
 * Non authentifier
 * */
Route::group(['prefix' => 'auth', 'middleware' => 'guest:api', 'namespace' => 'Auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'RegisterController@register');
    Route::post('password/send-reset-link-email', 'ForgotPasswordController@recover');
    Route::post('password/forgot-password-reset/{token}', 'ResetPasswordController@reset');
    Route::post('password/generate-password-reset', 'ResetPasswordController@generateNewPassword');

   // Route::get('email/verify-email/{token}', 'VerificationController@verify')->name('user.verify');
   // Route::post('email/resend-link-email', 'VerificationController@resend')->name('user.resend');;

    // La page où on présente les liens de redirection vers les providers
    Route::get("login-register", "SocialiteController@loginRegister");

    // La redirection vers le provider
    Route::get("redirect/{provider}", "SocialiteController@redirect")->name('socialite.redirect');
    // Le callback du provider
    Route::get("callback/{provider}", "SocialiteController@callback")->name('socialite.callback');
});

////////////////////////AUTHENTIFIER  PLATE-FORME  SITE WEB ET ADMINSTRATION
Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'middleware' => ['api', 'jwt.auth']], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('me', 'AuthController@me');
    Route::put('change-password', 'AuthController@changePassword');
    Route::get('refresh', 'AuthController@refresh');
});

/*////////////////////////NON AUTHENTIFIER  PLATE-FORME  SITE WEB
Route::group(['prefix' => 'website', 'middleware' => 'guest:api', 'namespace' => 'V1'], function () {
    Route::get('domain-activity/all', 'DomainActivityController@index')->name('all-domainActivities');
});*/


Route::group(['prefix' => 'website', 'middleware' => 'guest:api'], function () {

    Route::get('/domain-activities', 'DomainActivityAPIController@domainActivitiesWithCount');
    Route::get('/candidate-display-with-cat', 'CandidateAPIController@candidateDisplayWithCat'); // liste des candidate en fonction du groupe
    Route::get('/project-with-display', 'ProjectAPIController@projectWithDisplay'); // liste des projects pouvant etre publie sur le site web
    Route::get('/stats-web-site', 'StatisticAPIController@statsWebSite');
    Route::get('/testimonials', 'TestimonialAPIController@testimonialWebSite');
    Route::get('/questions', 'QuestionAPIController@questionWebSite');
    Route::get('/formations', 'FormationAPIController@formationWebSite');
    Route::get('/competences', 'CompetenceAPIController@getCompetenceListWebSite');
    Route::get('/groups', 'GroupAPIController@getGroupListWebSite');
    Route::get('/professions-by-domain-activity/{idDomainActivity}', 'ProfessionAPIController@getProfessionsByDomainWebSite');
    Route::get('/specialisms-by-profession/{idProfession}', 'SpecialismAPIController@getSpecialismsByProfessionWebSite');
    Route::get('/specialisms', 'SpecialismAPIController@getSpecialismsWebSite');
    Route::get('/search-candidate', 'CandidateAPIController@searchCandidate');

});



Route::resource('advertisements', AdvertisementAPIController::class)->except(['create', 'edit']);

Route::resource('candidates', CandidateAPIController::class)->except(['create', 'edit']);

Route::resource('competences', CompetenceAPIController::class)->except(['create', 'edit']);

Route::resource('conditions', ConditionAPIController::class)->except(['create', 'edit']);

Route::resource('documents', DocumentAPIController::class)->except(['create', 'edit']);

Route::resource('domain-activities', DomainActivityAPIController::class)->except(['create', 'edit']);

Route::resource('education', EducationAPIController::class)->except(['create', 'edit']);

Route::resource('favorites', FavoriteAPIController::class)->except(['create', 'edit']);

Route::resource('formations', FormationAPIController::class)->except(['create', 'edit']);

Route::resource('groups', GroupAPIController::class)->except(['create', 'edit']);

Route::resource('invoices', InvoiceAPIController::class)->except(['create', 'edit']);

Route::resource('logs', LogAPIController::class)->except(['create', 'edit']);

Route::resource('messages', MessageAPIController::class)->except(['create', 'edit']);

Route::resource('newsletters', NewsletterAPIController::class)->except(['create', 'edit']);

Route::resource('oauth-providers', OauthProviderAPIController::class)->except(['create', 'edit']);

Route::resource('packages', PackageAPIController::class)->except(['create', 'edit']);

Route::resource('payments', PaymentAPIController::class)->except(['create', 'edit']);

Route::resource('permissions', PermissionAPIController::class)->except(['create', 'edit']);

Route::resource('professions', ProfessionAPIController::class)->except(['create', 'edit']);

Route::resource('projects', ProjectAPIController::class)->except(['create', 'edit']);

Route::resource('questions', QuestionAPIController::class)->except(['create', 'edit']);

Route::resource('reviews', ReviewAPIController::class)->except(['create', 'edit']);

Route::resource('roles', RoleAPIController::class)->except(['create', 'edit']);

Route::resource('specialisms', SpecialismAPIController::class)->except(['create', 'edit']);

Route::resource('statuses', StatusAPIController::class)->except(['create', 'edit']);

Route::resource('subscriptions', SubscriptionAPIController::class)->except(['create', 'edit']);

Route::resource('tasks', TaskAPIController::class)->except(['create', 'edit']);

Route::resource('testimonials', TestimonialAPIController::class)->except(['create', 'edit']);

Route::resource('type-documents', TypeDocumentAPIController::class)->except(['create', 'edit']);

Route::resource('users', UserAPIController::class)->except(['create', 'edit']);
