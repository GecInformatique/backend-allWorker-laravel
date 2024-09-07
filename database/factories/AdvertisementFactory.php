<?php

namespace Database\Factories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Advertisement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
        'description' => $this->faker->word,
        'period_start' => $this->faker->date('Y-m-d H:i:s'),
        'period_end' => $this->faker->date('Y-m-d H:i:s'),
        'cible' => $this->faker->word,
        'image_url' => $this->faker->word,
        'video_url' => $this->faker->word,
        'status' => $this->faker->word,
        'budget' => $this->faker->word,
        'clics' => $this->faker->randomDigitNotNull,
        'impressions' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
