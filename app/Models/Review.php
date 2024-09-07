<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Review",
 *      required={},
 *      @OA\Property(
 *          property="comment",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="username",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
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
 *          property="approuve_review",
 *          description="permet au client d&#039;appouvé le commentaire du  freelancers , apres la realisation de son projet",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="published_online",
 *          description="publiee le commentaire du projet au grand publique ",
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
 *          description="commentaire reponse a  un projet",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Review extends Model
{
     use SoftDeletes;    public $table = 'reviews';

    public $fillable = [
        'comment',
        'username',
        'email',
        'picture',
        'enable',
        'approuve_review',
        'rating',
        'published_online',
        'candidate_id',
        'project_id',
        'parent_review_id'
    ];

    protected $casts = [
        'comment' => 'string',
        'username' => 'string',
        'email' => 'string',
        'picture' => 'string',
        'enable' => 'boolean',
        'approuve_review' => 'boolean',
        'published_online' => 'boolean',
        'project_id' => 'string'
    ];

    public static $rules = [
        'comment' => 'nullable|string|max:65535',
        'username' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:45',
        'picture' => 'nullable|string',
        'enable' => 'nullable|boolean',
        'approuve_review' => 'nullable|boolean',
        'rating' => 'nullable',
        'published_online' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
        'candidate_id' => 'nullable',
        'project_id' => 'nullable|string|max:25',
        'parent_review_id' => 'nullable'
    ];

    public function candidate()
    {
        return $this->belongsTo(\App\Models\Candidate::class, 'candidate_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id');
    }
}
