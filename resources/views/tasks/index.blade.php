@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <x-page-header title="Tasks" subtitle="Project tasks and milestones">
        <x-slot:actions>
            <a href="{{ route('tasks.gantt') }}" class="btn btn-label-info btn-round me-2"><i class="fa fa-stream"></i> Gantt</a>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Task</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-header">
            <form method="GET" class="d-flex align-items-center gap-2">
                <label class="me-2 mb-0">Project</label>
                <select name="project_id" class="form-select" style="max-width:280px" onchange="this.form.submit()">
                    <option value="">All projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected($projectId == $project->id)>{{ $project->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Name</th><th>Project</th><th>Type</th><th>Assignee</th><th>Timeline</th><th class="text-center">Progress</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->project->name ?? '-' }}</td>
                                <td><span class="badge {{ $task->type === 'milestone' ? 'badge-warning' : 'badge-secondary' }} text-capitalize">{{ $task->type }}</span></td>
                                <td>{{ $task->assignee->name ?? '-' }}</td>
                                <td>{{ optional($task->start_date)->format('d M') }} - {{ optional($task->end_date)->format('d M Y') }}</td>
                                <td class="text-center">{{ $task->progress }}%</td>
                                <td class="text-capitalize">{{ $task->status }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this task?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">No tasks yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $tasks->links() }}</div>
@endsection
