<div class="card mb-3 task-card">
    <div class="card-header bg-{{ $task->category === 'Meal' ? 'primary' : ($task->category === 'Sleep' ? 'success' : ($task->category === 'Exercise' ? 'warning' : 'secondary')) }} bg-opacity-10">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $task->name }}</h5>
            <span class="badge bg-{{ $task->category === 'Meal' ? 'primary' : ($task->category === 'Sleep' ? 'success' : ($task->category === 'Exercise' ? 'warning' : 'secondary')) }}">{{ $task->category }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <p>{{ $task->description }}</p>
        </div>

        <div class="mb-3">
            <h6>Scientific Evidence</h6>
            <div class="evidence-box p-2 bg-light rounded border">
                <p class="mb-0 small">{{ $task->scientific_evidence }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h6>Benefits</h6>
                <ul class="benefits-list small">
                    @foreach(explode("\n", $task->benefits) as $benefit)
                        @if(!empty(trim($benefit)))
                            <li>{{ $benefit }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Points</h6>
                        <p class="fw-bold text-primary">+{{ $task->default_points }} pts</p>
                    </div>
                    <div>
                        @if($task->has_timer)
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-alarm"></i> {{ $task->timer_duration / 60 }} minutes
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @auth
            <div class="mt-3 d-flex justify-content-end">
                @if(isset($isUserTask) && $isUserTask)
                    <form action="{{ route('tasks.remove-from-my-tasks', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Remove from My Tasks</button>
                    </form>
                @else
                    <form action="{{ route('tasks.add-to-my-tasks', $task) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Add to My Tasks</button>
                    </form>
                @endif
            </div>
        @endauth
    </div>
</div>
