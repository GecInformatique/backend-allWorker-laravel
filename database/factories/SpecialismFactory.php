<?php

namespace Database\Factories;

use App\Models\Specialism;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialismFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Specialism::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'description' => $this->faker->word,
        'icon' => $this->faker->word,
        'enable' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'professions_id' => $this->faker->randomDigitNotNull
        ];
    }
}
