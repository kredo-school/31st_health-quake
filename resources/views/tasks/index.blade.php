@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('健康習慣タスク一覧') }}</h4>
                    @auth
                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">新しいタスクを提案</a>
                    @endauth
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="taskTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">すべて</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="food-tab" data-bs-toggle="tab" data-bs-target="#food" type="button" role="tab" aria-controls="food" aria-selected="false">食事</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sleep-tab" data-bs-toggle="tab" data-bs-target="#sleep" type="button" role="tab" aria-controls="sleep" aria-selected="false">睡眠</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="exercise-tab" data-bs-toggle="tab" data-bs-target="#exercise" type="button" role="tab" aria-controls="exercise" aria-selected="false">運動</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">その他</button>
                        </li>
                        @auth
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="my-tab" data-bs-toggle="tab" data-bs-target="#my" type="button" role="tab" aria-controls="my" aria-selected="false">マイタスク</button>
                            </li>
                        @endauth
                    </ul>

                    <div class="tab-content" id="taskTabsContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            @foreach($tasks as $task)
                                @include('tasks.partials.task-card', ['task' => $task])
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="food" role="tabpanel" aria-labelledby="food-tab">
                            @foreach($tasks->where('category', '食事') as $task)
                                @include('tasks.partials.task-card', ['task' => $task])
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="sleep" role="tabpanel" aria-labelledby="sleep-tab">
                            @foreach($tasks->where('category', '睡眠') as $task)
                                @include('tasks.partials.task-card', ['task' => $task])
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="exercise" role="tabpanel" aria-labelledby="exercise-tab">
                            @foreach($tasks->where('category', '運動') as $task)
                                @include('tasks.partials.task-card', ['task' => $task])
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                            @foreach($tasks->where('category', 'その他') as $task)
                                @include('tasks.partials.task-card', ['task' => $task])
                            @endforeach
                        </div>
                        @auth
                            <div class="tab-pane fade" id="my" role="tabpanel" aria-labelledby="my-tab">
                                @if(count($userTasks) > 0)
                                    @foreach($userTasks as $task)
                                        @include('tasks.partials.task-card', ['task' => $task, 'isUserTask' => true])
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        まだタスクを追加していません。健康習慣を始めるには、上記のタブからタスクを追加してください。
                                    </div>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
