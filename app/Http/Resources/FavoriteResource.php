<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
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
            'candidate_name' => $this->candidate_name,
            'candidate_email' => $this->candidate_email,
            'candidate_phone' => $this->candidate_phone,
            'candidate_picture' => $this->candidate_picture,
            'candidate_work_place' => $this->candidate_work_place,
            'date_of_last_activity' => $this->date_of_last_activity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'candidates_id' => $this->candidates_id
        ];
    }
}
