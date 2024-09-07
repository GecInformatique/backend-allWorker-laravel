<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @OA\Schema(
 *      schema="Testimonial",
 *      required={},
 *      @OA\Property(
 *          property="username",
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
 *          property="workplace",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="rating",
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
 */class Testimonial extends Model
{
     use SoftDeletes;    public $table = 'testimonials';

    public $fillable = [
        'username',
        'description',
        'picture',
        'enable',
        'workplace',
        'rating'
    ];

    protected $casts = [
        'username' => 'string',
        'description' => 'string',
        'picture' => 'string',
        'enable' => 'boolean',
        'workplace' => 'string',
        'rating' => 'float'
    ];

    public static $rules = [
        'username' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'picture' => 'nullable|string',
        'enable' => 'nullable|boolean',
        'workplace' => 'nullable|string|max:205',
        'rating' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function getPictureAttribute($value)
    {
        if(isset($value)){
            return asset("assets/images/testimonials/".$value);
        }else{
            return asset("assets/images/placeholder.png");
        }
    }

}
