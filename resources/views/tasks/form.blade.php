@extends('layouts.app')

@section('title', $task->exists ? 'Edit Task' : 'Add Task')

@section('content')
    <x-page-header :title="$task->exists ? 'Edit Task' : 'Add Task'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $task->exists ? route('tasks.update', $task) : route('tasks.store') }}">
                @csrf
                @if ($task->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project</label>
                            <select name="project_id" class="form-select" required>
                                <option value="">-- Select project --</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" @selected(old('project_id', $task->project_id) == $project->id)>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $task->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-select">
                                <option value="task" @selected(old('type', $task->type) === 'task')>Task</option>
                                <option value="milestone" @selected(old('type', $task->type) === 'milestone')>Milestone</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($task->start_date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($task->end_date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Progress (%)</label>
                            <input type="number" min="0" max="100" name="progress" class="form-control" value="{{ old('progress', $task->progress ?? 0) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Parent Task</label>
                            <select name="parent_id" class="form-select">
                                <option value="">-- None --</option>
                                @foreach ($parentTasks as $parent)
                                    <option value="{{ $parent->id }}" @selected(old('parent_id', $task->parent_id) == $parent->id)>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Assigned To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">-- Unassigned --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to', $task->assigned_to) == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control" value="{{ old('status', $task->status ?? 'pending') }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Depends On</label>
                            <select name="dependencies[]" class="form-select" multiple size="4">
                                @foreach ($allTasks as $dep)
                                    <option value="{{ $dep->id }}" @selected(in_array($dep->id, old('dependencies', $selectedDependencies)))>{{ $dep->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple prerequisite tasks.</small>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
