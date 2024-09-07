<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Specialism",
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
 *          property="icon",
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
 */class Specialism extends Model
{
     use SoftDeletes;    public $table = 'specialisms';

    public $fillable = [
        'name',
        'description',
        'icon',
        'enable',
        'professions_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'icon' => 'string',
        'enable' => 'boolean'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'icon' => 'nullable|string|max:105',
        'enable' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'professions_id' => 'nullable'
    ];

    public function profession()
    {
        return $this->belongsTo(\App\Models\Profession::class, 'professions_id');
    }

    public function candidate()
    {
        return $this->hasMany(\App\Models\Candidate::class, 'specialisms_id');
    }
}
