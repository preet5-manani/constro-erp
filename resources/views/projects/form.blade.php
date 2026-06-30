@extends('layouts.app')

@section('title', $project->exists ? 'Edit Project' : 'Add Project')

@section('content')
    <x-page-header :title="$project->exists ? 'Edit Project' : 'Add Project'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $project->exists ? route('projects.update', $project) : route('projects.store') }}">
                @csrf
                @if ($project->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $project->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $project->location) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                @foreach (['planning', 'active', 'completed', 'on_hold'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($project->end_date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Budget</label>
                            <input type="number" step="0.01" name="budget" class="form-control" value="{{ old('budget', $project->budget) }}">
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('projects.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
