<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Education",
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
 *          property="date_end",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="date_start",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="university_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
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
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="diploma",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
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
 */class Education extends Model
{
     use SoftDeletes;    public $table = 'educations';

    public $fillable = [
        'name',
        'description',
        'enable',
        'date_end',
        'date_start',
        'university_name',
        'diploma',
        'candidates_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'enable' => 'boolean',
        'date_end' => 'date',
        'date_start' => 'date',
        'university_name' => 'string',
        'diploma' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'enable' => 'nullable|boolean',
        'date_end' => 'nullable',
        'date_start' => 'nullable',
        'university_name' => 'nullable|string|max:255',
        'updated_at' => 'nullable',
        'created_at' => 'nullable',
        'diploma' => 'nullable|string|max:255',
        'deleted_at' => 'nullable',
        'candidates_id' => 'nullable'
    ];

    public function candidate()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'candidates_id');
    }
}
