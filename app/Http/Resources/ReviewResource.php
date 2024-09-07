<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'username' => $this->username,
            'email' => $this->email,
            'picture' => $this->picture,
            'enable' => $this->enable,
            'approuve_review' => $this->approuve_review,
            'rating' => $this->rating,
            'published_online' => $this->published_online,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'candidate_id' => $this->candidate_id,
            'project_id' => $this->project_id,
            'parent_review_id' => $this->parent_review_id
        ];
    }
}
