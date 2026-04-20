<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyMatchMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_match_id',
        'user_id',
        'content',
    ];

    public function match(): BelongsTo
    {
        return $this->belongsTo(StudyMatch::class, 'study_match_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
