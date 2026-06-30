@extends('layouts.app')

@section('title', $tower->exists ? 'Edit Tower' : 'Add Tower')

@section('content')
    <x-page-header :title="$tower->exists ? 'Edit Tower' : 'Add Tower'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $tower->exists ? route('towers.update', $tower) : route('towers.store') }}">
                @csrf
                @if ($tower->exists) @method('PUT') @endif

                <div class="form-group">
                    <label>Project</label>
                    <select name="project_id" class="form-select" required>
                        <option value="">-- Select project --</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id', $tower->project_id) == $project->id)>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tower Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $tower->name) }}" required>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('towers.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
