<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Log",
 *      required={},
 *      @OA\Property(
 *          property="action",
 *          description="&#039;Pending&#039;, &#039;In Progress&#039;, &#039;Completed&#039;, &#039;Cancelled&#039;, &#039;Failed&#039;,&#039;Paid&#039;",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="user_info",
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
 *      )
 * )
 */class Log extends Model
{
     use SoftDeletes;    public $table = 'logs';

    public $fillable = [
        'action',
        'user_info'
    ];

    protected $casts = [
        'action' => 'string',
        'user_info' => 'string'
    ];

    public static $rules = [
        'action' => 'nullable|string|max:75',
        'user_info' => 'nullable|string|max:45',
        'created_at' => 'nullable'
    ];


}
