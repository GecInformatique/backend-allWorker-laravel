<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Subscription",
 *      required={"cancel_at_period_end","candidate_id","package_id"},
 *      @OA\Property(
 *          property="status",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="period_start",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="period_end",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="cancel_at_period_end",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="method_payment",
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
 */class Subscription extends Model
{
     use SoftDeletes;    public $table = 'subscriptions';

    public $fillable = [
        'status',
        'name',
        'period_start',
        'period_end',
        'cancel_at_period_end',
        'validity_in_days',
        'method_payment',
        'description',
        'candidate_id',
        'package_id'
    ];

    protected $casts = [
        'status' => 'boolean',
        'name' => 'string',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'cancel_at_period_end' => 'boolean',
        'method_payment' => 'string',
        'description' => 'string'
    ];

    public static $rules = [
        'status' => 'nullable|boolean',
        'name' => 'nullable|string|max:255',
        'period_start' => 'nullable',
        'period_end' => 'nullable',
        'cancel_at_period_end' => 'required|boolean',
        'validity_in_days' => 'nullable',
        'method_payment' => 'nullable|string|max:45',
        'description' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'candidate_id' => 'required',
        'package_id' => 'required'
    ];

    public function candidate()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'candidate_id');
    }

    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class, 'package_id');
    }
}
