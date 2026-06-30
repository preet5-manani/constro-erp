@extends('layouts.app')

@section('title', 'Contractors')

@section('content')
    <x-page-header title="Contractors" subtitle="Subcontractor directory">
        <x-slot:actions>
            <a href="{{ route('contractors.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Contractor</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Name</th><th>Specialization</th><th>Phone</th><th class="text-center">Tasks</th><th class="text-center">Attendance</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($contractors as $contractor)
                            <tr>
                                <td>{{ $contractor->name }}</td>
                                <td>{{ $contractor->specialization ?? '-' }}</td>
                                <td>{{ $contractor->phone ?? '-' }}</td>
                                <td class="text-center">{{ $contractor->tasks_count }}</td>
                                <td class="text-center">{{ $contractor->attendances_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('contractors.edit', $contractor) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('contractors.destroy', $contractor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this contractor?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No contractors yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $contractors->links() }}</div>
@endsection
