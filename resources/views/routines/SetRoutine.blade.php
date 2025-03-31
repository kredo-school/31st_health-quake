<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Calendar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calendar-container">
        <!-- ヘッダー -->
        <div class="calendar-header">
            <h2>habits history <span id="current-month">March</span></h2>
            <div class="controls">
                <button id="prev-month"><</button>
                <button id="next-month">></button>
            </div>
        </div>

        <!-- 曜日ラベル -->
        <div class="weekdays">
            <span>SUN</span>
            <span>MON</span>
            <span>TUE</span>
            <span>WED</span>
            <span>THU</span>
            <span>FRI</span>
            <span>SAT</span>
        </div>

        <!-- 日付セル -->
        <div class="calendar-grid" id="calendar-grid"></div>

        <!-- 右上のタスクアイコン一覧 -->
        <div class="task-icons">
            <div class="icon-box" style="background-color: #4CAF50;"></div>
            <div class="icon-box" style="background-color: #FF9800;"></div>
            <div class="icon-box" style="background-color: #2196F3;"></div>
            <div class="icon-box" style="background-color: #FFC107;"></div>
            <div class="icon-box" style="background-color: #9C27B0;"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
