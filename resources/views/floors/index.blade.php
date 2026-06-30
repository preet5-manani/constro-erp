@extends('layouts.app')

@section('title', 'Floors')

@section('content')
    <x-page-header title="Floors" subtitle="Floors within towers">
        <x-slot:actions>
            <a href="{{ route('floors.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Floor</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Floor #</th><th>Tower</th><th>Project</th><th class="text-center">Flats</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($floors as $floor)
                            <tr>
                                <td>{{ $floor->floor_number }}</td>
                                <td>{{ $floor->tower->name ?? '-' }}</td>
                                <td>{{ $floor->tower->project->name ?? '-' }}</td>
                                <td class="text-center">{{ $floor->flats_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('floors.edit', $floor) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('floors.destroy', $floor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this floor?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No floors yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $floors->links() }}</div>
@endsection
