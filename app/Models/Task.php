<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Task",
 *      required={"status","projects_id","freelancer_id"},
 *      @OA\Property(
 *          property="id",
 *          description="",
 *          readOnly=true,
 *          nullable=false,
 *          type="string",
 *      ),
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
 *          property="status",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
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
 *          property="projects_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      )
 * )
 */class Task extends Model
{
     use SoftDeletes;    public $table = 'tasks';

    public $fillable = [
        'name',
        'description',
        'enable',
        'status',
        'date_end',
        'date_start',
        'projects_id',
        'freelancer_id'
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'enable' => 'boolean',
        'status' => 'string',
        'date_end' => 'date',
        'date_start' => 'date',
        'projects_id' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'enable' => 'nullable|boolean',
        'status' => 'required|string|max:70',
        'date_end' => 'nullable',
        'date_start' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'projects_id' => 'required|string|max:25',
        'freelancer_id' => 'required'
    ];

    public function freelancer()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'freelancer_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'projects_id');
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'tasks_id');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'task_id');
    }
}
