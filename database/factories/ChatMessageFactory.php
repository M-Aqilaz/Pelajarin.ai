<?php

namespace Database\Factories;

use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    public function definition(): array
    {
        return [
            'thread_id' => ChatThread::factory(),
            'role' => fake()->randomElement(['user', 'assistant']),
            'content' => fake()->paragraph(),
            'token_count' => fake()->numberBetween(12, 180),
        ];
    }
}
