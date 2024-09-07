<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Package",
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
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
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
 */class Package extends Model
{
     use SoftDeletes;    public $table = 'packages';

    public $fillable = [
        'name',
        'description',
        'amount',
        'enable'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'amount' => 'decimal:2',
        'enable' => 'boolean'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'amount' => 'nullable|numeric',
        'enable' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function conditions()
    {
        return $this->hasMany(\App\Models\Condition::class, 'package_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class, 'package_id');
    }
}
