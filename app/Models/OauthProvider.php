<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="OauthProvider",
 *      required={"candidate_id"},
 *      @OA\Property(
 *          property="provider",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="provider_user_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="access_token",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="refresh_token",
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
 */class OauthProvider extends Model
{
     use SoftDeletes;    public $table = 'oauth_providers';

    public $fillable = [
        'candidate_id',
        'provider',
        'provider_user_id',
        'access_token',
        'refresh_token'
    ];

    protected $casts = [
        'provider' => 'string',
        'provider_user_id' => 'string',
        'access_token' => 'string',
        'refresh_token' => 'string'
    ];

    public static $rules = [
        'candidate_id' => 'required',
        'provider' => 'nullable|string|max:205',
        'provider_user_id' => 'nullable|string|max:255',
        'access_token' => 'nullable|string|max:205',
        'refresh_token' => 'nullable|string|max:250',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function candidate()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'candidate_id');
    }
}
