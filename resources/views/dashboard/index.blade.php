@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('あなたのHealth Quakeダッシュボード') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <img src="{{ asset('images/level-badge.png') }}" alt="レベル" width="60" height="60" class="rounded-circle">
                                </div>
                                <div>
                                    <h5 class="mb-0">レベル {{ $userLevel->level ?? 1 }}</h5>
                                    <div class="progress mt-2" style="height: 10px;">
                                        @php
                                            $percentage = $userLevel ? ($userLevel->experience_points / $userLevel->points_to_next_level) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small>次のレベルまで {{ $userLevel->points_to_next_level - $userLevel->experience_points ?? 100 }} ポイント</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h6>健康習慣の統計</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        完了したタスク数
                                        <span class="badge bg-primary rounded-pill">{{ $completedTasksCount ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        連続達成日数
                                        <span class="badge bg-success rounded-pill">{{ $consecutiveDays ?? 0 }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        現在の習慣数
                                        <span class="badge bg-info rounded-pill">{{ $activeTasks ?? 0 }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5>今日のルーティン</h5>
                            @if(isset($routines) && count($routines) > 0)
                                @foreach($routines as $routine)
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">{{ $routine->name }}</h6>
                                                <span class="badge bg-{{ $routine->type === '朝' ? 'warning' : ($routine->type === '昼' ? 'info' : 'secondary') }}">{{ $routine->type }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="task-list">
                                                @foreach($routine->tasks as $task)
                                                    <div class="task-item d-flex align-items-center mb-2 p-2 {{ $task->pivot->is_completed ? 'bg-light' : '' }}" style="border-radius: 5px; border: 1px solid #eee;">
                                                        <div class="me-3">
                                                            <form action="{{ route('user-tasks.complete', $task->pivot->id) }}" method="POST">
                                                                @csrf
                                                                <div class="form-check">
                                                                    <input class="form-check-input task-checkbox" type="checkbox" value="1" id="task{{ $task->id }}"
                                                                        {{ $task->pivot->is_completed ? 'checked' : '' }}
                                                                        onChange="this.form.submit()">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <strong>{{ $task->name }}</strong>
                                                                    <p class="mb-0 text-muted small">{{ Str::limit($task->description, 100) }}</p>
                                                                </div>
                                                                <div>
                                                                    <span class="badge bg-primary">+{{ $task->pivot->points ?? $task->default_points }} pts</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    ルーティンがまだ設定されていません。<a href="{{ route('routines.create') }}">新しいルーティンを作成</a>しましょう！
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">今月のカレンダー</h5>
                        </div>
                        <div class="card-body">
                            <div class="calendar-month">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6>{{ now()->format('Y年n月') }}</h6>
                                </div>
                                <div class="calendar-grid">
                                    <!-- カレンダーグリッドをここに実装 -->
                                    <div class="row text-center">
                                        <div class="col">日</div>
                                        <div class="col">月</div>
                                        <div class="col">火</div>
                                        <div class="col">水</div>
                                        <div class="col">木</div>
                                        <div class="col">金</div>
                                        <div class="col">土</div>
                                    </div>
                                    <!-- カレンダー日付部分は実際のデータから動的に生成 -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">科学的ヒント</h5>
                        </div>
                        <div class="card-body">
                            <div class="science-tip">
                                <h6>今日の健康習慣ヒント</h6>
                                <p>「簡単なことから始める」という原則は、行動心理学で実証されています。小さな一歩から始めることで、モチベーションが高まり、習慣形成が促進されます。例えば、30分のエクササイズが難しい場合は、まず5分から始めましょう。</p>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm">もっと読む</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">あなたの健康習慣の進捗</h5>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary">全タスクを見る</a>
                </div>
                <div class="card-body">
                    <div class="progress-chart">
                        <!-- 進捗グラフを実装 -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h2 class="display-4 text-primary">{{ $foodTasksCompletionRate ?? 0 }}%</h2>
                                        <p class="text-muted">食事の健康習慣</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h2 class="display-4 text-success">{{ $sleepTasksCompletionRate ?? 0 }}%</h2>
                                        <p class="text-muted">睡眠の健康習慣</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h2 class="display-4 text-warning">{{ $exerciseTasksCompletionRate ?? 0 }}%</h2>
                                        <p class="text-muted">運動の健康習慣</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
