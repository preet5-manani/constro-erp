@extends('layouts.app')

@section('title', 'Contractor Assignments')

@section('content')
    <x-page-header title="Contractor Assignments" subtitle="Tasks assigned to contractors">
        <x-slot:actions>
            <a href="{{ route('contractor-tasks.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Assign Task</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Contractor</th><th>Task</th><th>Project</th><th>Status</th><th class="text-center">Progress</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($contractorTasks as $ct)
                            <tr>
                                <td>{{ $ct->contractor->name ?? '-' }}</td>
                                <td>{{ $ct->task->name ?? '-' }}</td>
                                <td>{{ $ct->task->project->name ?? '-' }}</td>
                                <td class="text-capitalize">{{ $ct->status }}</td>
                                <td class="text-center">{{ $ct->progress }}%</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('contractor-tasks.edit', $ct) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('contractor-tasks.destroy', $ct) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this assignment?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No assignments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $contractorTasks->links() }}</div>
@endsection
