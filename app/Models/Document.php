<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Document",
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
 *          property="path",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="extention",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="size",
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
 *      ),
 *      @OA\Property(
 *          property="project_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="tasks_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Document extends Model
{
     use SoftDeletes;    public $table = 'documents';

    public $fillable = [
        'name',
        'description',
        'path',
        'extention',
        'size',
        'enable',
        'type_document_id',
        'candidates_id',
        'project_id',
        'tasks_id'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'path' => 'string',
        'extention' => 'string',
        'size' => 'decimal:2',
        'enable' => 'boolean',
        'project_id' => 'string',
        'tasks_id' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:45',
        'description' => 'nullable|string|max:255',
        'path' => 'nullable|string|max:105',
        'extention' => 'nullable|string|max:45',
        'size' => 'nullable|numeric',
        'enable' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'type_document_id' => 'nullable',
        'candidates_id' => 'nullable',
        'project_id' => 'nullable|string|max:25',
        'tasks_id' => 'nullable|string|max:25'
    ];

    public function candidate()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'candidates_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id');
    }

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class, 'tasks_id');
    }

    public function typeDocument()
    {
        return $this->belongsTo(\App\Models\TypeDocument::class, 'type_document_id');
    }
}
