<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *      schema="Candidate",
 *      required={"profile_update","status_user","group_id","full_name","email","phone_number"},
 *      @OA\Property(
 *          property="qr_code",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="enable",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="is_partner",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="published_online",
 *          description="me rendre visible et disponible en ligne",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="profile_update",
 *          description="apres la modification des information l admintrateur doit verifier le profile si celui ci est conforme",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="profile_verify_by_admin",
 *          description="verifier les document cni , passport",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="profile_certificate",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="my_logo",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="picture",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="full_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="owner_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="pseudo",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="phone_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="gender",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="day_birth",
 *          description="
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="post_box",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="rating",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="date_start_experience",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="current_salary",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="city",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="complete_address",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="nationality",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="language",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type_disponibility",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="status_user",
 *          description="&#039;Pending&#039;, &#039;In Progress&#039;, &#039;Completed&#039;, &#039;Cancelled&#039;",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="status_receiver_notification_job",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="website",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="overview",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="last_connection",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="remember_token",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="link_google",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="link_twitter",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="link_facebook",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="link_linkedin",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="link_instagram",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="deleted_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */

class Candidate extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    public $table = 'candidates';

    public $hidden = [
        'password',
        'remember_token',
    ];

    public $fillable = [
        'qr_code',
        'enable',
        'is_partner',
        'published_online',
        'profile_update',
        'profile_verify_by_admin',
        'profile_certificate',
        'my_logo',
        'picture',
        'email',
        'password',
        'full_name',
        'owner_name',
        'pseudo',
        'phone_number',
        'gender',
        'day_birth',
        'post_box',
        'rating',
        'date_start_experience',
        'current_salary',
        'city',
        'complete_address',
        'nationality',
        'language',
        'type_disponibility',
        'longitude',
        'latitude',
        'status_user',
        'status_receiver_notification_job',
        'website',
        'overview',
        'email_verified_at',
        'last_connection',
        'remember_token',
        'link_google',
        'link_twitter',
        'link_facebook',
        'link_linkedin',
        'link_instagram',
        'specialisms_id',
        'group_id',

        //nouvelle
        'domain_activity_id',
        'profession_id',
        'user_id'  // Ajout de l'attribut user_id
    ];

    protected $casts = [
        'qr_code' => 'string',
        'enable' => 'boolean',
        'is_partner' => 'boolean',
        'published_online' => 'boolean',
        'profile_update' => 'boolean',
        'profile_verify_by_admin' => 'boolean',
        'profile_certificate' => 'boolean',
        'my_logo' => 'string',
        'picture' => 'string',
        'email' => 'string',
        'password' => 'string',
        'full_name' => 'string',
        'owner_name' => 'string',
        'pseudo' => 'string',
        'phone_number' => 'string',
        'gender' => 'string',
        'day_birth' => 'date',
        'post_box' => 'string',
        'rating' => 'float',
        'date_start_experience' => 'date',
        'current_salary' => 'decimal:2',
        'city' => 'string',
        'complete_address' => 'string',
        'nationality' => 'string',
        'language' => 'string',
        'type_disponibility' => 'string',
        'longitude' => 'float',
        'latitude' => 'float',
        'status_user' => 'string',
        'status_receiver_notification_job' => 'boolean',
        'website' => 'string',
        'overview' => 'string',
        'email_verified_at' => 'datetime',
        'last_connection' => 'datetime',
        'remember_token' => 'string',
        'link_google' => 'string',
        'link_twitter' => 'string',
        'link_facebook' => 'string',
        'link_linkedin' => 'string',
        'link_instagram' => 'string',

        //nouvelle ajout
        'domain_activity_id' => 'integer',
        'profession_id' => 'integer',
        'user_id' => 'integer',  // Ajout du cast pour user_id
    ];

    public static $rules = [
        'qr_code' => 'nullable|string|max:255',
        'enable' => 'nullable|boolean',
        'is_partner' => 'nullable|boolean',
        'published_online' => 'nullable|boolean',
        'profile_update' => 'required|boolean|max:40',
        'profile_verify_by_admin' => 'nullable|boolean',
        'profile_certificate' => 'nullable|boolean',
        'my_logo' => 'nullable|string|max:16777215',
        'picture' => 'nullable|string|max:16777215',
        'email' => 'nullable|email:filter|max:255|unique:candidates',
        'password' => 'nullable|string|max:105',
        'full_name' => 'required|string|max:105',
        'owner_name' => 'nullable|string|max:255',
        'pseudo' => 'nullable|string|max:45',
        'phone_number' => 'nullable|string|max:45',
        'gender' => 'nullable|string|max:15',
        'day_birth' => 'nullable',
        'post_box' => 'nullable|string|max:45',
        'rating' => 'nullable|numeric',
        'date_start_experience' => 'nullable',
        'current_salary' => 'nullable|numeric',
        'city' => 'nullable|string|max:45',
        'complete_address' => 'nullable|string|max:255',
        'nationality' => 'nullable|string|max:100',
        'language' => 'nullable|string|max:50',
        'type_disponibility' => 'nullable|string|max:50',
        'longitude' => 'nullable|numeric',
        'latitude' => 'nullable|numeric',
        'status_user' => 'required|string|max:25',
        'status_receiver_notification_job' => 'nullable|boolean',
        'website' => 'nullable|string|max:255',
        'overview' => 'nullable|string',
        'email_verified_at' => 'nullable',
        'last_connection' => 'nullable',
        'remember_token' => 'nullable|string|max:105',
        'link_google' => 'nullable|string|max:105',
        'link_twitter' => 'nullable|string|max:105',
        'link_facebook' => 'nullable|string|max:105',
        'link_linkedin' => 'nullable|string|max:105',
        'link_instagram' => 'nullable|string|max:105',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'specialisms_id' => 'nullable',
        'group_id' => 'required',

        //nouvelle ajout
        'domain_activity_id' => 'nullable|integer',
        'profession_id' => 'nullable|integer',
        'user_id' => 'nullable|exists:users,id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email'=>$this->email,
            'name'=>$this->name
        ];
    }

    public function getPictureAttribute($value)
    {
        if(isset($value)){
            return asset("assets/images/candidates/freelancers/".$value);
        }else{
            return asset("assets/images/placeholder.png");
        }
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class, 'group_id');
    }

    public function specialism()
    {
        return $this->belongsTo(\App\Models\Specialism::class, 'specialisms_id');
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'candidates_has_competences', 'candidates_id', 'competences_id');
        ///return $this->belongsToMany(\App\Models\Competence::class, 'candidates_has_competences');
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'candidates_id');
    }



    public function education()
    {
        return $this->hasMany(\App\Models\Education::class, 'candidates_id');
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorite::class, 'candidates_id');
    }

    public function oauthProviders()
    {
        return $this->hasMany(\App\Models\OauthProvider::class, 'candidate_id');
    }

    public function projects()
    {
        return $this->hasMany(\App\Models\Project::class, 'client_id');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'candidate_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class, 'candidate_id');
    }

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'freelancer_id');
    }


    // nouvelle ajout


    public function domainActivity()
    {
        return $this->belongsTo(\App\Models\DomainActivity::class, 'domain_activity_id');
    }

    public function profession()
    {
        return $this->belongsTo(\App\Models\Profession::class, 'profession_id');
    }

    public function specialities()
    {
        return $this->belongsToMany(\App\Models\Speciality::class, 'candidates_has_specialities', 'candidates_id', 'specialities_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
