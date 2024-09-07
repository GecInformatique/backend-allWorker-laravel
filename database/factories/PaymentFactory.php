<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'amount' => $this->faker->word,
        'status' => $this->faker->word,
        'payment_date' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'task_id' => $this->faker->word
        ];
    }
}
