<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="DomainActivity",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="icon",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
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
 */class DomainActivity extends Model
{
     use SoftDeletes;    public $table = 'domain_activities';

    public $fillable = [
        'name',
        'icon',
        'description',
        'enable'
    ];

    protected $casts = [
        'name' => 'string',
        'icon' => 'string',
        'description' => 'string',
        'enable' => 'boolean'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'icon' => 'nullable|string|max:105',
        'description' => 'nullable|string|max:65535',
        'enable' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function getIconAttribute($value)
    {
        if(isset($value)){
            return asset("assets/images/domains/".$value);
        }else{
            return asset("assets/images/placeholder.png");
        }
    }

    public function formations()
    {
        return $this->hasMany(\App\Models\Formation::class, 'domain_activities_id');
    }

    public function professions()
    {
        return $this->hasMany(\App\Models\Profession::class, 'domain_activities_id');
    }
}
