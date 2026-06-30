@extends('layouts.app')

@section('title', 'Towers')

@section('content')
    <x-page-header title="Towers" subtitle="Towers within projects">
        <x-slot:actions>
            <a href="{{ route('towers.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Tower</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Name</th><th>Project</th><th class="text-center">Floors</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($towers as $tower)
                            <tr>
                                <td><a href="{{ route('towers.show', $tower) }}">{{ $tower->name }}</a></td>
                                <td>{{ $tower->project->name ?? '-' }}</td>
                                <td class="text-center">{{ $tower->floors_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('towers.edit', $tower) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('towers.destroy', $tower) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tower?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No towers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $towers->links() }}</div>
@endsection
