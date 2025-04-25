<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'date', 'user_id','is_completed','last_completed'];

    // 🔽 ここを追加：日付カラムをCarbonオブジェクトとして扱う
    protected $casts = [
        'date' => 'date',
        
    ];

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
