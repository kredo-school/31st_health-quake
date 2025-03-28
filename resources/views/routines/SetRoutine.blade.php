{{-- <!DOCTYPE html>    set-routineでブラウザ上で調べればみれる --}}
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Settings</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/SetRoutine.css">
</head>
<body>
    <div class="container-fluid">
        <!-- ヘッダー -->
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#"></a> <!-- ロゴを削除 -->
            <ul class="nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Calendar</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Task</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ranking</a></li>
            </ul>
            <img src="https://via.placeholder.com/50?text=User" alt="User Icon" class="user-icon">
        </nav>

        <!-- メインコンテンツ -->
        <div class="content">
            <!-- 日付選択 -->
            <div class="date-selector">
                <h3>December, 2025</h3>
                <div class="days">
                    <span class="day">Mon</span>
                    <span class="day">Tue</span>
                    <span class="day">Wed</span>
                    <span class="day">Thu</span>
                    <span class="day">Fri</span>
                    <span class="day">Sat</span>
                    <span class="day">Sun</span>
                </div>
                <div class="numbers">
                    <span class="number">8</span>
                    <span class="number active">9</span>
                    <span class="number">10</span>
                    <span class="number">11</span>
                    <span class="number">12</span>
                    <span class="number">13</span>
                    <span class="number">14</span>
                </div>
            </div>

            <!-- Add Habit ボタン -->
            <a href="{{ route('add_habit') }}" class="btn btn-outline-secondary add-habit-btn">Add habits</a>

            <h1>List Habits</h1>
            <!-- 習慣一覧 -->
            <div class="habit-cards">
                @foreach($habits as $habit)
                <div class="habit-card card-blue" data-habit-id="{{ $habit->id }}">
                    <table>
                        <tr>
                            <td>{{ $habit->name }}</td>
                            <td>{{ $habit->category }}</td>
                            <td>{{ $habit->date }}</td>
                        </tr>
                    </table>
                    <!-- 削除ボタン -->
                    <button class="btn btn-danger delete-habit-btn" data-habit-id="{{ $habit->id }}">削除</button>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 削除ボタンを取得
            const deleteButtons = document.querySelectorAll('.delete-habit-btn');

            // 各削除ボタンにイベントリスナーを追加
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const habitId = this.getAttribute('data-habit-id'); // 習慣のIDを取得

                    if (confirm('本当にこの習慣を削除しますか？')) {
                        // APIにDELETEリクエストを送信
                        fetch(`/api/habits/${habitId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${localStorage.getItem('token')}` // JWTトークン（認証用）
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                alert('習慣が削除されました');
                                // UIから削除された習慣を即座に取り除く
                                const habitCard = document.querySelector(`[data-habit-id="${habitId}"]`);
                                if (habitCard) {
                                    habitCard.remove();
                                }
                            } else {
                                alert('削除に失敗しました');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('通信エラーが発生しました');
                        });
                    }
                });
            });
        });
        </script>
</body>
</html>
