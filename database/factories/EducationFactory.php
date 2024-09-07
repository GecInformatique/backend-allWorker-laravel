<?php

namespace Database\Factories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Education::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'description' => $this->faker->text,
        'enable' => $this->faker->word,
        'date_end' => $this->faker->word,
        'date_start' => $this->faker->word,
        'university_name' => $this->faker->word,
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'diploma' => $this->faker->word,
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'candidates_id' => $this->faker->randomDigitNotNull
        ];
    }
}
