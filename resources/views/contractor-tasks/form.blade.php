@extends('layouts.app')

@section('title', $contractorTask->exists ? 'Edit Assignment' : 'Assign Task')

@section('content')
    <x-page-header :title="$contractorTask->exists ? 'Edit Assignment' : 'Assign Task'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $contractorTask->exists ? route('contractor-tasks.update', $contractorTask) : route('contractor-tasks.store') }}">
                @csrf
                @if ($contractorTask->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contractor</label>
                            <select name="contractor_id" class="form-select" required>
                                <option value="">-- Select contractor --</option>
                                @foreach ($contractors as $contractor)
                                    <option value="{{ $contractor->id }}" @selected(old('contractor_id', $contractorTask->contractor_id) == $contractor->id)>{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Task</label>
                            <select name="task_id" class="form-select" required>
                                <option value="">-- Select task --</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}" @selected(old('task_id', $contractorTask->task_id) == $task->id)>{{ $task->name }} ({{ $task->project->name ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control" value="{{ old('status', $contractorTask->status ?? 'pending') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Progress (%)</label>
                            <input type="number" min="0" max="100" name="progress" class="form-control" value="{{ old('progress', $contractorTask->progress ?? 0) }}">
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('contractor-tasks.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
