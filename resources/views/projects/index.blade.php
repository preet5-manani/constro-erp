@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <x-page-header title="Projects" subtitle="Real estate development projects">
        <x-slot:actions>
            <a href="{{ route('projects.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Project</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th class="text-end">Budget</th>
                            <th class="text-center">Towers</th>
                            <th class="text-center">Tasks</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td><a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></td>
                                <td>{{ $project->location ?? '-' }}</td>
                                <td><span class="badge badge-info text-capitalize">{{ str_replace('_', ' ', $project->status) }}</span></td>
                                <td class="text-end">{{ number_format($project->budget, 2) }}</td>
                                <td class="text-center">{{ $project->towers_count }}</td>
                                <td class="text-center">{{ $project->tasks_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No projects yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $projects->links() }}</div>
@endsection
