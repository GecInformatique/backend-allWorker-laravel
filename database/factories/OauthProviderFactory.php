<?php

namespace Database\Factories;

use App\Models\OauthProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class OauthProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OauthProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'candidate_id' => $this->faker->randomDigitNotNull,
        'provider' => $this->faker->word,
        'provider_user_id' => $this->faker->word,
        'access_token' => $this->faker->word,
        'refresh_token' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
