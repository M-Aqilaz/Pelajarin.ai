<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_set_id',
        'user_id',
        'score',
        'total_questions',
        'percentage',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'percentage' => 'float',
            'completed_at' => 'datetime',
        ];
    }

    public function quizSet(): BelongsTo
    {
        return $this->belongsTo(QuizSet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
