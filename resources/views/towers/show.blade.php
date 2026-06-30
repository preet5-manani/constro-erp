@extends('layouts.app')

@section('title', $tower->name)

@section('content')
    <x-page-header :title="$tower->name" :subtitle="'Project: ' . ($tower->project->name ?? '-')">
        <x-slot:actions>
            <a href="{{ route('towers.edit', $tower) }}" class="btn btn-primary btn-round"><i class="fa fa-edit"></i> Edit</a>
            <a href="{{ route('towers.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-header"><div class="card-title">Floors</div></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Floor Number</th><th class="text-center">Flats</th></tr></thead>
                    <tbody>
                        @forelse ($tower->floors as $floor)
                            <tr><td>{{ $floor->floor_number }}</td><td class="text-center">{{ $floor->flats_count }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-4 text-muted">No floors yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
