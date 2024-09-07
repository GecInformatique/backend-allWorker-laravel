<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Advertisement",
 *      required={"cible"},
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
 *          property="cible",
 *          description="Public cible de la publicité (par exemple, âge, sexe, intérêt).",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="image_url",
 *          description="Type de formation (présentiel, en ligne, hybride, etc.)",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="video_url",
 *          description="Niveau de la formation (débutant, intermédiaire, avancé, etc.)",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="Statut de la publicité (par exemple, active, inactive, expirée).",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="budget",
 *          description="Budget alloué pour la publicité.",
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
 */class Advertisement extends Model
{
     use SoftDeletes;    public $table = 'advertisements';

    public $fillable = [
        'title',
        'description',
        'period_start',
        'period_end',
        'cible',
        'image_url',
        'video_url',
        'status',
        'budget',
        'clics',
        'impressions'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'cible' => 'string',
        'image_url' => 'string',
        'video_url' => 'string',
        'status' => 'string',
        'budget' => 'decimal:2'
    ];

    public static $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'period_start' => 'nullable',
        'period_end' => 'nullable',
        'cible' => 'required|string|max:200',
        'image_url' => 'nullable|string|max:250',
        'video_url' => 'nullable|string|max:255',
        'status' => 'nullable|string|max:45',
        'budget' => 'nullable|numeric',
        'clics' => 'nullable',
        'impressions' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
