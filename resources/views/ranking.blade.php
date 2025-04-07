<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <style>
        /* 全体のスタイル */
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f7ff;
            /* 軽い青色の背景 */
            margin: 0;
            padding: 0;
        }

        /* ヘッダー部分 */
        header {
            background-color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .logo span {
            font-weight: bold;
            color: #333;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        /* メインコンテンツ */
        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .rank-item {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 15px;
        }

        .rank-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .rank-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }

        .rank-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .rank-points {
            font-size: 14px;
            color: #666;
            margin-left: auto;
        }

        /* ユーザーの現在位置を示すマーク */
        .user-position {
            position: relative;
            margin-top: -20px;
            margin-left: 20px;
        }

        .user-position::before {
            content: "";
            position: absolute;
            top: 50%;
            left: -20px;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 10px 0 10px 20px;
            border-color: transparent transparent transparent #ffcc00;
            /* 黄色の三角形 */
        }

        .user-position span {
            font-size: 14px;
            color: #666;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <!-- ヘッダー -->
    <header>
        <div class="logo">
            <img src="https://via.placeholder.com/50" alt="Logo">
            <span>HEALTH QUAKE</span>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Calendar</a></li>
                <li><a href="#">Task</a></li>
                <li><a href="#">Ranking</a></li>
            </ul>
        </nav>
        <div class="profile">
            <img src="https://via.placeholder.com/50" alt="Profile" style="border-radius: 50%;">
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main>
        @foreach ($ranks as $rank)
            <div class="rank-item">
                <img src="{{ $rank['avatar'] }}" alt="{{ $rank['name'] }}">
                <div>
                    <span class="rank-number">#{{ $rank['position'] }}</span>
                    <span class="rank-name">{{ $rank['name'] }}</span>
                </div>
                <span class="rank-points">{{ $rank['points'] }} points</span>
                @if ($loop->iteration === 4)
                    <!-- 例として4番目の要素にマークを付ける -->
                    <div class="user-position">
                        <span>You are here</span>
                    </div>
                @endif
            </div>
        @endforeach
    </main>
</body>

</html>
