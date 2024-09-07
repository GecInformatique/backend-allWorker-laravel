<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="User",
 *      required={"role_id"},
 *      @OA\Property(
 *          property="enable",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="picture",
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
 *          property="full_name",
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
 */class User extends Model
{
     use SoftDeletes;    public $table = 'users';

    public $fillable = [
        'enable',
        'picture',
        'pseudo',
        'full_name',
        'email',
        'password',
        'role_id'
    ];

    protected $casts = [
        'enable' => 'boolean',
        'picture' => 'string',
        'pseudo' => 'string',
        'full_name' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];

    public static $rules = [
        'enable' => 'nullable|boolean',
        'picture' => 'nullable|string|max:100',
        'pseudo' => 'nullable|string|max:45',
        'full_name' => 'nullable|string|max:105',
        'email' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:105',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'role_id' => 'required'
    ];

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
