<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'status' => $this->status,
            'name' => $this->name,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'cancel_at_period_end' => $this->cancel_at_period_end,
            'validity_in_days' => $this->validity_in_days,
            'method_payment' => $this->method_payment,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'candidate_id' => $this->candidate_id,
            'package_id' => $this->package_id
        ];
    }
}
