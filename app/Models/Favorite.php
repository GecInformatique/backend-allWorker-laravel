<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Favorite",
 *      required={"candidates_id"},
 *      @OA\Property(
 *          property="candidate_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="candidate_email",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="candidate_phone",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="candidate_picture",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="candidate_work_place",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="date_of_last_activity",
 *          description="",
 *          readOnly=false,
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
 */class Favorite extends Model
{
     use SoftDeletes;    public $table = 'favorites';

    public $fillable = [
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'candidate_picture',
        'candidate_work_place',
        'date_of_last_activity',
        'candidates_id'
    ];

    protected $casts = [
        'candidate_name' => 'string',
        'candidate_email' => 'string',
        'candidate_phone' => 'string',
        'candidate_picture' => 'string',
        'candidate_work_place' => 'string',
        'date_of_last_activity' => 'datetime'
    ];

    public static $rules = [
        'candidate_name' => 'nullable|string|max:205',
        'candidate_email' => 'nullable|string|max:150',
        'candidate_phone' => 'nullable|string|max:40',
        'candidate_picture' => 'nullable|string|max:80',
        'candidate_work_place' => 'nullable|string|max:105',
        'date_of_last_activity' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'candidates_id' => 'required'
    ];

    public function candidate()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'candidates_id');
    }
}
