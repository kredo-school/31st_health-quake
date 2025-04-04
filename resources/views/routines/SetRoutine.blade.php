<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF トークン用 meta タグ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('delete-habit',['id'=>$habit->id]) }}" class="btn btn-danger delete-habit-btn" data-habit-id="{{ $habit->id }}">削除</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>



</body>

</html>
