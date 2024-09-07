<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Group",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="&#039;Freelancer&#039;, &#039;Client&#039;, &#039;Compagnie&#039;",
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
 */class Group extends Model
{
     use SoftDeletes;    public $table = 'groupes';

    public $fillable = [
        'name',
        'description',
        'icon'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'icon' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:45',
        'description' => 'nullable|string|max:255',
        'icon' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function candidates()
    {
        return $this->hasMany(\App\Models\Candidate::class, 'groupes_id');
    }
}
