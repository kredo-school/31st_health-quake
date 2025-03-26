<!-- resources/views/habit_list.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* 水色の背景 */
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('add_habit') }}" class="btn btn-primary">Add habit</a>
        </div>
        <h2>List Habits (recommendation)</h2>

        <!-- 登録済みの Habit を表示 -->
        <h3>Your Habits</h3>
        <div class="row">
            @forelse ($habits as $habit)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $habit->name }}</h5>
                            <p class="card-text">{{ $habit->category }}</p>
                            <p class="card-text"><small class="text-muted">{{ $habit->date }}</small></p>
                        </div>
                    </div>
                </div>
            @empty
                <p>No habits registered yet.</p>
            @endforelse
        </div>

        <!-- 推奨の Habit カード -->
        <h3>Recommended Habits</h3>
        @include('partials.habits')
    </div>
</body>
</html>
