<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OauthProviderResource extends JsonResource
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
            'candidate_id' => $this->candidate_id,
            'provider' => $this->provider,
            'provider_user_id' => $this->provider_user_id,
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
