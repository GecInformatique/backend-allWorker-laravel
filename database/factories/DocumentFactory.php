<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

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
        'path' => $this->faker->word,
        'extention' => $this->faker->word,
        'size' => $this->faker->word,
        'enable' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'type_document_id' => $this->faker->randomDigitNotNull,
        'candidates_id' => $this->faker->randomDigitNotNull,
        'project_id' => $this->faker->word,
        'tasks_id' => $this->faker->word
        ];
    }
}
