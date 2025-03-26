<!DOCTYPE html>
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
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/100?text=HEALTH+QUAKE" alt="Logo" class="logo">
            </a>
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
            <button class="btn btn-outline-secondary add-habit-btn">Add habit</button>

            <!-- 習慣一覧 -->
            <div class="habit-cards">
                <div class="habit-card card-blue">
                    <img src="https://via.placeholder.com/200?text=Don't smoke" alt="Don't smoke" class="card-image">
                    <h4 class="card-title">Don't smoke</h4>
                    <button class="btn btn-primary card-tag">Health</button>
                </div>
                <div class="habit-card card-purple">
                    <img src="https://via.placeholder.com/200?text=Glass of water" alt="Glass of water" class="card-image">
                    <h4 class="card-title">Glass of water</h4>
                    <button class="btn btn-secondary card-tag">Health</button>
                </div>
                <div class="habit-card card-green">
                    <img src="https://via.placeholder.com/200?text=Get outside" alt="Get outside" class="card-image">
                    <h4 class="card-title">Get outside</h4>
                    <button class="btn btn-success card-tag">Adventure</button>
                </div>
                <div class="habit-card card-pink">
                    <img src="https://via.placeholder.com/200?text=Morning exercise" alt="Morning exercise" class="card-image">
                    <h4 class="card-title">Morning exercise</h4>
                    <button class="btn btn-danger card-tag">Meditation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>