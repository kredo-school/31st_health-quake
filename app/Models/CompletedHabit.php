<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedHabit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'completed_date',
        'duration_seconds'
    ];

    protected $casts = [
        'completed_date' => 'date',
    ];

    // ユーザーリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
