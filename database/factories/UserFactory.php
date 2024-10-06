<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'username_user' =>  $this->faker->randomElement(['admin', 'user']),
            'password_user' => Hash::make('123456789'),
            'nama_user' => $this->faker->sentence(5),
            'alamat_user' => $this->faker->sentence(5),
            'nomor_telp' => $this->faker->sentence(5),
            'jabatan' => $this->faker->randomElement(['admin', 'user']),

        ];
    }
}
