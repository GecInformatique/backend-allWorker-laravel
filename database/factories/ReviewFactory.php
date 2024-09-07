<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->text,
        'username' => $this->faker->word,
        'email' => $this->faker->word,
        'picture' => $this->faker->text,
        'enable' => $this->faker->word,
        'approuve_review' => $this->faker->word,
        'rating' => $this->faker->randomDigitNotNull,
        'published_online' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'candidate_id' => $this->faker->randomDigitNotNull,
        'project_id' => $this->faker->word,
        'parent_review_id' => $this->faker->randomDigitNotNull
        ];
    }
}
