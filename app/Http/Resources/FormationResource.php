<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'trainer' => $this->trainer,
            'duree' => $this->duree,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'location' => $this->location,
            'type' => $this->type,
            'price' => $this->price,
            'level' => $this->level,
            'prerequis' => $this->prerequis,
            'status' => $this->status,
            'number_places' => $this->number_places,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'domain_activities_id' => $this->domain_activities_id
        ];
    }
}
