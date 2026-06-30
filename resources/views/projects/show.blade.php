@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <x-page-header :title="$project->name" :subtitle="$project->location">
        <x-slot:actions>
            <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary btn-round"><i class="fa fa-edit"></i> Edit</a>
            <a href="{{ route('projects.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-md-3"><x-stat-card label="Status" :value="ucwords(str_replace('_',' ',$project->status))" icon="fas fa-info-circle" color="info" /></div>
        <div class="col-md-3"><x-stat-card label="Budget" :value="number_format($project->budget, 2)" icon="fas fa-coins" color="success" /></div>
        <div class="col-md-3"><x-stat-card label="Towers" :value="$project->towers->count()" icon="fas fa-building" color="primary" /></div>
        <div class="col-md-3"><x-stat-card label="Timeline" :value="optional($project->start_date)->format('d M Y') ?? '-'" icon="fas fa-calendar" color="secondary" /></div>
    </div>

    <div class="card card-round">
        <div class="card-header"><div class="card-title">Towers</div></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Name</th><th class="text-center">Floors</th></tr></thead>
                    <tbody>
                        @forelse ($project->towers as $tower)
                            <tr><td><a href="{{ route('towers.show', $tower) }}">{{ $tower->name }}</a></td><td class="text-center">{{ $tower->floors_count }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-4 text-muted">No towers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
