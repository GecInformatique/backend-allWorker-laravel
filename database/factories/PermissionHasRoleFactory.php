<?php

namespace Database\Factories;

use App\Models\PermissionsHasRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionHasRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PermissionsHasRole::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'roles_id' => $this->faker->randomDigitNotNull
        ];
    }
}
