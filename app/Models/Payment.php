<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Payment",
 *      required={"status"},
 *      @OA\Property(
 *          property="name",
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
 *          property="status",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="payment_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
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
 *          property="task_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Payment extends Model
{
     use SoftDeletes;    public $table = 'payments';

    public $fillable = [
        'name',
        'amount',
        'status',
        'payment_date',
        'task_id'
    ];

    protected $casts = [
        'name' => 'string',
        'amount' => 'decimal:2',
        'status' => 'string',
        'payment_date' => 'date',
        'task_id' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'amount' => 'nullable|numeric',
        'status' => 'required|string|max:70',
        'payment_date' => 'nullable',
        'created_at' => 'nullable',
        'task_id' => 'nullable|string|max:25'
    ];

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class, 'task_id');
    }
}
