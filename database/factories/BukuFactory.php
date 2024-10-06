<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'judul_buku' => $this->faker->unique()->text(5),
            'cover' => $this->faker->sentence(5),
            'dokumen' => $this->faker->sentence(5),
            
        ];
    }
}
