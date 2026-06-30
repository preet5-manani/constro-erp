@extends('layouts.app')

@section('title', 'Gantt Chart')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.css">
@endpush

@section('content')
    <x-page-header title="Gantt Chart" subtitle="Project timeline and task dependencies">
        <x-slot:actions>
            <a href="{{ route('tasks.index') }}" class="btn btn-border btn-round">Task List</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-header">
            <form method="GET" class="d-flex align-items-center gap-2">
                <label class="me-2 mb-0">Project</label>
                <select name="project_id" class="form-select" style="max-width:280px" onchange="this.form.submit()">
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected($projectId == $project->id)>{{ $project->name }}</option>
                    @endforeach
                </select>
                <div class="ms-auto btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-light gantt-mode" data-mode="Day">Day</button>
                    <button type="button" class="btn btn-sm btn-light gantt-mode" data-mode="Week">Week</button>
                    <button type="button" class="btn btn-sm btn-light gantt-mode" data-mode="Month">Month</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if (count($ganttData))
                <svg id="ganttChart"></svg>
            @else
                <p class="text-center text-muted py-5 mb-0">No tasks with dates for this project yet. Add tasks with start and end dates to see the Gantt chart.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js"></script>
<script>
    (function () {
        var tasks = @json($ganttData);
        if (!tasks.length || !document.getElementById('ganttChart')) return;
        var gantt = new Gantt("#ganttChart", tasks, { view_mode: 'Week', date_format: 'YYYY-MM-DD' });
        document.querySelectorAll('.gantt-mode').forEach(function (btn) {
            btn.addEventListener('click', function () { gantt.change_view_mode(this.dataset.mode); });
        });
    })();
</script>
@endpush
