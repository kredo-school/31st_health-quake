<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Habit</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
            /* 水色の背景 */
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        h2 {
            color: #e74c3c;
            /* オレンジ色のタイトル */
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-success {
            width: 100%;
        }

        .recommended-habits {
            margin-top: 30px;
        }

        .card {
            margin-bottom: 15px;
        }

        /* ドロップダウンメニューのスタイル */
        .dropdown-menu {
            display: none;
            /* 初期状態で非表示 */
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
            /* クリック時に表示 */
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- エラーメッセージの表示 -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- 成功メッセージの表示 -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Set your Habit</h2>
        <form action="{{ route('save_habit') }}" method="POST">
            @csrf <!-- CSRFトークンを追加 -->

            <div class="form-group">
                <label for="name">Habit name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Category部分をクリック可能にする -->
            <div class="form-group dropdown">
                <label for="category">Category</label>

                <label for="options">Choose an option:</label>
                <select id="options" name="options">
                    <option value="1">Exercise Category</option>
                    <option value="2">Nutrition Category</option>
                    <option value="3">Sleep Category</option>
                    <option value="3">Other Categories</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>

        <!-- 推奨の Habit カード -->
        <h3 class="recommended-habits">Recommended Habits</h3>
        @include('partials.habits') <!-- 正しいパスに修正 -->

        <div class="habit-cards">
            <div class="habit-card card-blue">

            </div>
            <div class="habit-card card-purple">

            </div>
            <div class="habit-card card-green">

            </div>
            <div class="habit-card card-pink">

            </div>
        </div>
    </div>

    <!-- jQueryとBootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- 自作JavaScript -->
    <script>
        // Categoryボタンをクリックしたときの処理
        document.getElementById('categoryButton').addEventListener('click', function() {
            const dropdownMenu = this.nextElementSibling; // ドロップダウンメニュー要素を取得
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show'); // 表示解除
            } else {
                dropdownMenu.classList.add('show'); // 表示
            }
        });
    </script>
</body>

</html>
