<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'candidate_name' => $this->faker->word,
        'candidate_email' => $this->faker->word,
        'candidate_phone' => $this->faker->word,
        'candidate_picture' => $this->faker->word,
        'candidate_work_place' => $this->faker->word,
        'date_of_last_activity' => $this->faker->date('Y-m-d H:i:s'),
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'candidates_id' => $this->faker->randomDigitNotNull
        ];
    }
}
