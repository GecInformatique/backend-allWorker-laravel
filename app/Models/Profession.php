<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Profession",
 *      required={},
 *      @OA\Property(
 *          property="name",
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
 *          property="icon",
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
 */class Profession extends Model
{
     use SoftDeletes;    public $table = 'professions';

    public $fillable = [
        'name',
        'description',
        'enable',
        'icon',
        'domain_activities_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'enable' => 'boolean',
        'icon' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:65535',
        'enable' => 'nullable|boolean',
        'icon' => 'nullable|string|max:105',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'domain_activities_id' => 'nullable'
    ];

    public function domainActivity()
    {
        return $this->belongsTo(\App\Models\DomainActivity::class, 'domain_activities_id');
    }

    public function specialisms()
    {
        return $this->hasMany(\App\Models\Specialism::class, 'professions_id');
    }
}
