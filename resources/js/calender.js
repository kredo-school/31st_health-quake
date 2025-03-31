document.addEventListener('DOMContentLoaded', function () {
    const calendarGrid = document.getElementById('calendar-grid');
    const currentMonthElement = document.getElementById('current-month');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');

    let currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let currentMonth = currentDate.getMonth(); // 0-based (0 = January)

    function generateCalendar() {
        // カレンダーをクリア
        calendarGrid.innerHTML = '';

        // 現在の月の最初の日を取得
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
        const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);

        // 月初めの曜日を取得（0 = Sunday, 1 = Monday, ...）
        const startDayOfWeek = firstDayOfMonth.getDay();

        // 表示用の日付配列を作成
        const daysInMonth = [];
        for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
            daysInMonth.push(i);
        }

        // 空白セルを追加（月初めの空白部分）
        for (let i = 0; i < startDayOfWeek; i++) {
            const cell = document.createElement('div');
            cell.classList.add('day-cell');
            calendarGrid.appendChild(cell);
        }

        // 日付セルを追加
        daysInMonth.forEach(day => {
            const cell = document.createElement('div');
            cell.classList.add('day-cell');
            cell.textContent = day;

            // クリックイベントを追加
            cell.addEventListener('click', function () {
                alert(`Clicked on ${day} of ${currentMonthElement.textContent}`);
            });

            calendarGrid.appendChild(cell);
        });

        // 現在の月を表示
        currentMonthElement.textContent = getMonthName(currentMonth);
    }

    function getMonthName(monthIndex) {
        const months = ['January', 'February', 'March', 'April', 'May', 'June',
                       'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthIndex];
    }

    // 前の月へ移動
    prevMonthButton.addEventListener('click', function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar();
    });

    // 次の月へ移動
    nextMonthButton.addEventListener('click', function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar();
    });

    // 初期表示
    generateCalendar();
});
