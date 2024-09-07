<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'enable' => $this->enable,
            'date_end' => $this->date_end,
            'date_start' => $this->date_start,
            'university_name' => $this->university_name,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'diploma' => $this->diploma,
            'deleted_at' => $this->deleted_at,
            'candidates_id' => $this->candidates_id
        ];
    }
}
