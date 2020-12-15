<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName,
            'telephone' => $this->faker->e164PhoneNumber,
            'birthday' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->unique()->email,
            'password' => $this->faker->password(),
        ];
    }
}
