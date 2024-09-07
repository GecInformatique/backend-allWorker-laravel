<?php

namespace Database\Factories;

use App\Models\CandidatesHasCompetence;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateHasCompetenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CandidatesHasCompetence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'competences_id' => $this->faker->randomDigitNotNull
        ];
    }
}
