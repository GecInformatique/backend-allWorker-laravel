<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->word,
        'name' => $this->faker->word,
        'period_start' => $this->faker->date('Y-m-d H:i:s'),
        'period_end' => $this->faker->date('Y-m-d H:i:s'),
        'cancel_at_period_end' => $this->faker->word,
        'validity_in_days' => $this->faker->randomDigitNotNull,
        'method_payment' => $this->faker->word,
        'description' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'candidate_id' => $this->faker->randomDigitNotNull,
        'package_id' => $this->faker->randomDigitNotNull
        ];
    }
}
