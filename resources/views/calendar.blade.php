@extends('layouts.app')

@section('content')
<div class="calendar-container">
    <!-- ヘッダー -->
    <div class="calendar-header">
        <h2>Habits History <span id="current-month">March</span></h2>
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
        <div class="icon-box" style="background-color: #4CAF50;">1</div>
        <div class="icon-box" style="background-color: #FF9800;">2</div>
        <div class="icon-box" style="background-color: #2196F3;">3</div>
        <div class="icon-box" style="background-color: #FFC107;">4</div>
        <div class="icon-box" style="background-color: #9C27B0;">5</div>
    </div>
</div>
{{-- @endsection --}}

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush


@endsection