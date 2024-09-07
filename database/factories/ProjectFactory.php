<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

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
        'status' => $this->faker->word,
        'date_end' => $this->faker->word,
        'date_start' => $this->faker->word,
        'date_expired' => $this->faker->word,
        'client_price' => $this->faker->word,
        'price_type' => $this->faker->word,
        'validate_project' => $this->faker->word,
        'freelancer_price' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'client_id' => $this->faker->randomDigitNotNull
        ];
    }
}
