<?php

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'qr_code' => $this->faker->word,
        'enable' => $this->faker->word,
        'is_partner' => $this->faker->word,
        'published_online' => $this->faker->word,
        'profile_update' => $this->faker->word,
        'profile_verify_by_admin' => $this->faker->word,
        'profile_cerificate' => $this->faker->word,
        'my_logo' => $this->faker->text,
        'picture' => $this->faker->text,
        'email' => $this->faker->word,
        'password' => $this->faker->word,
        'full_name' => $this->faker->word,
        'owner_name' => $this->faker->word,
        'pseudo' => $this->faker->word,
        'phone_number' => $this->faker->word,
        'gender' => $this->faker->word,
        'day_birth' => $this->faker->word,
        'post_box' => $this->faker->word,
        'rating' => $this->faker->randomDigitNotNull,
        'date_start_experience' => $this->faker->word,
        'current_salary' => $this->faker->word,
        'city' => $this->faker->word,
        'complete_address' => $this->faker->word,
        'nationality' => $this->faker->word,
        'longitude' => $this->faker->randomDigitNotNull,
        'latitude' => $this->faker->randomDigitNotNull,
        'status_user' => $this->faker->word,
        'status_receiver_notification_job' => $this->faker->word,
        'website' => $this->faker->word,
        'overview' => $this->faker->text,
        'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
        'last_connection' => $this->faker->date('Y-m-d H:i:s'),
        'remember_token' => $this->faker->word,
        'link_google' => $this->faker->word,
        'link_twitter' => $this->faker->word,
        'link_facebook' => $this->faker->word,
        'link_linkedin' => $this->faker->word,
        'link_instagram' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'specialisms_id' => $this->faker->randomDigitNotNull,
        'groupes_id' => $this->faker->randomDigitNotNull,
        'domain_activity_id' => $this->faker->randomDigitNotNull,
        'profession_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
