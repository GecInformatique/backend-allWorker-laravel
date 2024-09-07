<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
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
            'qr_code' => $this->qr_code,
            'enable' => $this->enable,
            'is_partner' => $this->is_partner,
            'published_online' => $this->published_online,
            'profile_update' => $this->profile_update,
            'profile_verify_by_admin' => $this->profile_verify_by_admin,
            'profile_cerificate' => $this->profile_cerificate,
            'my_logo' => $this->my_logo,
            'picture' => $this->picture,
            'email' => $this->email,
            'password' => $this->password,
            'full_name' => $this->full_name,
            'owner_name' => $this->owner_name,
            'pseudo' => $this->pseudo,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'day_birth' => $this->day_birth,
            'post_box' => $this->post_box,
            'rating' => $this->rating,
            'date_start_experience' => $this->date_start_experience,
            'current_salary' => $this->current_salary,
            'city' => $this->city,
            'complete_address' => $this->complete_address,
            'nationality' => $this->nationality,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'status_user' => $this->status_user,
            'status_receiver_notification_job' => $this->status_receiver_notification_job,
            'website' => $this->website,
            'overview' => $this->overview,
            'email_verified_at' => $this->email_verified_at,
            'last_connection' => $this->last_connection,
            'remember_token' => $this->remember_token,
            'link_google' => $this->link_google,
            'link_twitter' => $this->link_twitter,
            'link_facebook' => $this->link_facebook,
            'link_linkedin' => $this->link_linkedin,
            'link_instagram' => $this->link_instagram,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'specialisms_id' => $this->specialisms_id,
            'groupes_id' => $this->groupes_id
        ];
    }
}
