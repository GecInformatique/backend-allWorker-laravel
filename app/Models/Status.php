<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Status",
 *      required={},
 *      @OA\Property(
 *          property="id",
 *          description="&#039;pending&#039;, &#039;inprogress&#039;, &#039;completed&#039;, &#039;cancelled&#039;, &#039;failed&#039;,&#039;faid&#039;",
 *          readOnly=true,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          description="&#039;Pending&#039;, &#039;In Progress&#039;, &#039;Completed&#039;, &#039;Cancelled&#039;, &#039;Failed&#039;,&#039;Paid&#039;",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Status extends Model
{
     use SoftDeletes;    public $table = 'status';

    public $fillable = [
        'name'
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:75'
    ];


}
