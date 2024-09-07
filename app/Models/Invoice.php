<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Invoice",
 *      required={"status","projects_id"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="total_amount",
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
 *          property="invoice_date",
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
 *          property="projects_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      )
 * )
 */class Invoice extends Model
{
     use SoftDeletes;    public $table = 'invoices';

    public $fillable = [
        'name',
        'total_amount',
        'status',
        'invoice_date',
        'projects_id'
    ];

    protected $casts = [
        'name' => 'string',
        'total_amount' => 'decimal:2',
        'status' => 'string',
        'invoice_date' => 'datetime',
        'projects_id' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'total_amount' => 'nullable|numeric',
        'status' => 'required|string|max:70',
        'invoice_date' => 'nullable',
        'created_at' => 'nullable',
        'projects_id' => 'required|string|max:25'
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'projects_id');
    }
}
