<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'original_filename' => fake()->slug() . '.pdf',
            'file_path' => 'materials/' . fake()->uuid() . '.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => fake()->numberBetween(10_000, 500_000),
            'raw_text' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['uploaded', 'processed']),
        ];
    }
}
