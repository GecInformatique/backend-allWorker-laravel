<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'status' => $this->status,
            'date_end' => $this->date_end,
            'date_start' => $this->date_start,
            'date_expired' => $this->date_expired,
            'client_price' => $this->client_price,
            'price_type' => $this->price_type,
            'validate_project' => $this->validate_project,
            'freelancer_price' => $this->freelancer_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'client_id' => $this->client_id
        ];
    }
}
