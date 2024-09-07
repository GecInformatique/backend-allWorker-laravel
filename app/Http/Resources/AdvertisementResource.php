<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'cible' => $this->cible,
            'image_url' => $this->image_url,
            'video_url' => $this->video_url,
            'status' => $this->status,
            'budget' => $this->budget,
            'clics' => $this->clics,
            'impressions' => $this->impressions,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
