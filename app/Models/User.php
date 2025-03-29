<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Logファサードをインポート

class User extends Authenticatable
{
    /**
     * 外部から直接代入可能なカラム名を指定します。
     * これらのカラムは、モデルの `create()` や `update()` で使用できます。
     */
    protected $fillable = [
        'username', // ユーザー名（例: "john_doe"）
        'password', // パスワード（ハッシュ化された値が保存されます）
        'last_login_at', // 最終ログイン日時（タイムスタンプ形式）
        'consecutive_days', // 連続ログイン日数（整数）
        'level', // ユーザーのレベル（整数）
    ];

    /**
     * APIやJSON出力時に非表示にするカラム名を指定します。
     * ここでは、パスワードを隠すように設定しています。
     */
    protected $hidden = [
        'password', // パスワードは外部に出力しない
    ];

    /**
     * ログイン状態を更新するメソッドです。
     * このメソッドは、ユーザーがログインするたびに呼び出され、次の処理を行います：
     * 1. 同じ日に再度ログインした場合は何もしません。
     * 2. 前回ログインから1日経過していれば連続ログイン日数を増やします。
     * 3. 連続ログインが途切れた場合、連続ログイン日数をリセットします。
     * 4. 5日以上ログインしなかった場合、ペナルティーとしてレベルを下げます。
     * 5. 最終ログイン日時を更新し、データベースに保存します。
     */
    public function updateLoginStatus()
    {
        // 現在の日付を取得（例: "2023-10-01"）
        $today = now()->toDateString();

        // 前回ログイン日時を取得します（なければ null になります）
        $lastLoginDate = optional($this->last_login_at)->toDateString();

        /**
         * 同じ日に再度ログインした場合は何もしません。
         * これにより、1日に複数回ログインしても連続ログイン日数が重複して加算されるのを防ぎます。
         */
        if ($lastLoginDate === $today) {
            Log::info("[$this->username] Same day login detected. Skipping consecutive days update.");
            return;
        }

        /**
         * 前回ログインから1日経過していれば連続ログイン日数を増やします。
         * Carbon を使って日付を比較し、1日後の日付が現在の日付と一致するか確認します。
         */
        if ($lastLoginDate && Carbon::parse($lastLoginDate)->addDay()->isSameDay($today)) {
            $this->increment('consecutive_days'); // 連続ログイン日数を +1
            Log::info("[$this->username] Incremented consecutive days. New count: " . ($this->consecutive_days + 1));
        } else {
            /**
             * 連続ログインが途切れた場合、連続ログイン日数をリセットします。
             * 例えば、2日以上の間隔が空いた場合などに適用されます。
             */
            $this->consecutive_days = 1;
            Log::info("[$this->username] Consecutive login streak reset. New count: 1");
        }

        /**
         * 最終ログイン日時を更新します。
         * これにより、次回のログイン時に前回ログイン日時を基準に計算できます。
         */
        $this->last_login_at = now();
        Log::info("[$this->username] Updated last login time: " . $this->last_login_at);

        /**
         * 前回ログインから5日以上経過していた場合、ペナルティーとしてレベルを下げます。
         * Carbon の diffInDays() メソッドを使って日数差を計算します。
         */
        if ($lastLoginDate && Carbon::parse($lastLoginDate)->diffInDays(now()) >= 5) {
            $this->decrement('level'); // レベルを -1
            Log::info("[$this->username] Decreased level due to inactivity. New level: " . ($this->level - 1));
        }

        /**
         * データベースに変更内容を保存します。
         * save() メソッドを呼び出すことで、更新されたデータが永続化されます。
         */
        $this->save();
        Log::info("[$this->username] Saved user data successfully.");
    }
}