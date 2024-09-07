<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Project",
 *      required={"status","price_type","validate_project","client_id"},
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
 *          property="picture",
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
 *          property="published_online",
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
 *          property="date_expired",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="client_price",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="price_type",
 *          description="Fixed , Variable ",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="validate_project",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="freelancer_price",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
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
 */class Project extends Model
{
     use SoftDeletes;    public $table = 'projects';

    public $fillable = [
        'name',
        'description',
        'enable',
        'published_online',
        'status',
        'picture',
        'date_end',
        'date_start',
        'date_expired',
        'client_price',
        'price_type',
        'validate_project',
        'freelancer_price',
        'client_id'
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'picture' => 'string',
        'enable' => 'boolean',
        'published_online' => 'boolean',
        'status' => 'string',
        'date_end' => 'date',
        'date_start' => 'date',
        'date_expired' => 'date',
        'client_price' => 'decimal:2',
        'price_type' => 'string',
        'validate_project' => 'string',
        'freelancer_price' => 'decimal:2'
    ];

    public static $rules = [
        'name' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'picture' => 'nullable|string',
        'enable' => 'nullable|boolean',
        'published_online' => 'nullable|boolean',
        'status' => 'required|string|max:40',
        'date_end' => 'nullable',
        'date_start' => 'nullable',
        'date_expired' => 'nullable',
        'client_price' => 'nullable|numeric',
        'price_type' => 'required|string|max:45',
        'validate_project' => 'required|string|max:40',
        'freelancer_price' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'client_id' => 'required'
    ];

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getPictureAttribute($value)
    {
        if(isset($value)){
            return url("assets/images/projects/".$value);
        }else{
            return url("assets/images/placeholder.png");
        }
    }

    public function getClientPriceAttribute($value) {
        return $value ." FCFA";
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'client_id');
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'project_id');
    }

    public function invoices()
    {
        return $this->hasMany(\App\Models\Invoice::class, 'projects_id');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'projects_id');
    }
}
