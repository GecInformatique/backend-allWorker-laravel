<?php

namespace Database\Factories;

use App\Models\TypeDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'enable' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
