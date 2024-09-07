<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="TypeDocument",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="&#039;cv&#039;, &#039;cni&#039;, &#039;passport&#039;, &#039;other&#039;",
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
 *      )
 * )
 */class TypeDocument extends Model
{
     use SoftDeletes;    public $table = 'type_documents';

    public $fillable = [
        'name',
        'enable'
    ];

    protected $casts = [
        'name' => 'string',
        'enable' => 'boolean'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:45',
        'enable' => 'nullable|boolean',
        'created_at' => 'nullable'
    ];

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'type_document_id');
    }
}
