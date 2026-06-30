@extends('layouts.app')

@section('title', $floor->exists ? 'Edit Floor' : 'Add Floor')

@section('content')
    <x-page-header :title="$floor->exists ? 'Edit Floor' : 'Add Floor'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $floor->exists ? route('floors.update', $floor) : route('floors.store') }}">
                @csrf
                @if ($floor->exists) @method('PUT') @endif

                <div class="form-group">
                    <label>Tower</label>
                    <select name="tower_id" class="form-select" required>
                        <option value="">-- Select tower --</option>
                        @foreach ($towers as $tower)
                            <option value="{{ $tower->id }}" @selected(old('tower_id', $floor->tower_id) == $tower->id)>{{ $tower->name }} ({{ $tower->project->name ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Floor Number</label>
                    <input type="number" name="floor_number" class="form-control" value="{{ old('floor_number', $floor->floor_number) }}" required>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('floors.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
