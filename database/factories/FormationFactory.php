<?php

namespace Database\Factories;

use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formation::class;

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
        'trainer' => $this->faker->word,
        'duree' => $this->faker->randomDigitNotNull,
        'period_start' => $this->faker->date('Y-m-d H:i:s'),
        'period_end' => $this->faker->date('Y-m-d H:i:s'),
        'location' => $this->faker->word,
        'type' => $this->faker->word,
        'price' => $this->faker->word,
        'level' => $this->faker->word,
        'prerequis' => $this->faker->text,
        'status' => $this->faker->word,
        'number_places' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'domain_activities_id' => $this->faker->randomDigitNotNull
        ];
    }
}
