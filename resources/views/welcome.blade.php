<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Quake</title>
    <style>
        body {
            background-image: url('images/background.png'); /* 背景画像のパスを指定 */
            background-size: cover;
            background-position: center;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        .logo {
            width: 200px; /* ロゴのサイズを調整 */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Congratulations to all of you who have given up on a healthy lifestyle!</h1>
        <!-- ロゴをクリックすると register ページに遷移 -->
        <a href="{{ route('register') }}">
            <img src="images/logo.png" alt="Health Quake Logo" class="logo">
            <br>click here to start
        </a>
        <p>This app provides scientific support for human health habits. Using this app, you can develop good health habits with near 100% probability.</p>
    </div>
</body>
</html>