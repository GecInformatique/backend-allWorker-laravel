<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Formation",
 *      required={"location","domain_activities_id"},
 *      @OA\Property(
 *          property="title",
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
 *          property="trainer",
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
 *          property="location",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="Type de formation (présentiel, en ligne, hybride, etc.)",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="level",
 *          description="Niveau de la formation (débutant, intermédiaire, avancé, etc.)",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="prerequisite",
 *          description="Prérequis pour suivre la formation",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="Statut de la formation (en attente, confirmée, annulée, etc.)",
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
 */class Formation extends Model
{
     use SoftDeletes;    public $table = 'formations';

    public $fillable = [
        'title',
        'description',
        'picture',
        'trainer',
        'duration',
        'period_start',
        'period_end',
        'location',
        'type',
        'price',
        'level',
        'prerequisite',
        'status',
        'number_places',
        'domain_activities_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'picture' => 'string',
        'trainer' => 'string',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'location' => 'string',
        'type' => 'string',
        'price' => 'decimal:2',
        'level' => 'string',
        'prerequisite' => 'string',
        'status' => 'string'
    ];

    public static $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'picture' => 'nullable|string|max:255',
        'trainer' => 'nullable|string|max:255',
        'duration' => 'nullable',
        'period_start' => 'nullable',
        'period_end' => 'nullable',
        'location' => 'required|string|max:200',
        'type' => 'nullable|string|max:50',
        'price' => 'nullable|numeric',
        'level' => 'nullable|string|max:255',
        'prerequisite' => 'nullable|string|max:65535',
        'status' => 'nullable|string|max:45',
        'number_places' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'domain_activities_id' => 'required'
    ];

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getPictureAttribute($value)
    {
        if(isset($value)){
            return asset("assets/images/formations/".$value);
        }else{
            return asset("assets/images/placeholder.png");
        }
    }

    public function domainActivity()
    {
        return $this->belongsTo(\App\Models\DomainActivity::class, 'domain_activities_id');
    }
}
