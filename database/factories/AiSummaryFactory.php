<?php

namespace Database\Factories;

use App\Models\AiSummary;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiSummary>
 */
class AiSummaryFactory extends Factory
{
    protected $model = AiSummary::class;

    public function definition(): array
    {
        return [
            'material_id' => Material::factory(),
            'user_id' => User::factory(),
            'title' => 'Ringkasan ' . fake()->sentence(2),
            'summary_text' => fake()->paragraphs(2, true),
            'model' => 'openai/gpt-oss-120b:free',
        ];
    }
}
