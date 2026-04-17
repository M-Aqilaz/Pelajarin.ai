<?php

namespace Database\Seeders;

use App\Models\AiSummary;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Seeder;

class LearningFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'role' => 'user',
            ]
        );

        $material = Material::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Sejarah Kemerdekaan Indonesia',
            ],
            [
                'original_filename' => 'sejarah-kemerdekaan.pdf',
                'file_path' => 'materials/sejarah-kemerdekaan.pdf',
                'mime_type' => 'application/pdf',
                'file_size' => 248320,
                'status' => 'processed',
                'raw_text' => 'Vacuum of power terjadi setelah Jepang menyerah kepada Sekutu pada Agustus 1945 dan sebelum Sekutu tiba sepenuhnya di Indonesia.',
            ]
        );

        AiSummary::updateOrCreate(
            [
                'material_id' => $material->id,
                'user_id' => $user->id,
                'title' => 'Ringkasan Kemerdekaan',
            ],
            [
                'summary_text' => 'Kekosongan kekuasaan setelah Jepang menyerah dimanfaatkan para pemimpin Indonesia untuk mempercepat proklamasi kemerdekaan.',
                'model' => 'openai/gpt-oss-120b:free',
            ]
        );

        $thread = ChatThread::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Diskusi Vacuum of Power',
            ],
            [
                'material_id' => $material->id,
            ]
        );

        ChatMessage::updateOrCreate(
            [
                'thread_id' => $thread->id,
                'role' => 'user',
                'content' => 'Apa yang dimaksud vacuum of power?',
            ],
            [
                'token_count' => 18,
            ]
        );

        ChatMessage::updateOrCreate(
            [
                'thread_id' => $thread->id,
                'role' => 'assistant',
                'content' => 'Vacuum of power adalah kondisi ketika kekuasaan lama sudah jatuh, tetapi kekuasaan baru belum terbentuk secara penuh.',
            ],
            [
                'token_count' => 32,
            ]
        );
    }
}
