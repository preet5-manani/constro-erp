@extends('layouts.app')

@section('title', $flat->exists ? 'Edit Flat' : 'Add Flat')

@section('content')
    <x-page-header :title="$flat->exists ? 'Edit Flat' : 'Add Flat'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $flat->exists ? route('flats.update', $flat) : route('flats.store') }}">
                @csrf
                @if ($flat->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Floor</label>
                            <select name="floor_id" class="form-select" required>
                                <option value="">-- Select floor --</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->id }}" @selected(old('floor_id', $flat->floor_id) == $floor->id)>
                                        {{ $floor->tower->project->name ?? '-' }} / {{ $floor->tower->name ?? '-' }} / Floor {{ $floor->floor_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Flat Number</label>
                            <input type="text" name="flat_number" class="form-control" value="{{ old('flat_number', $flat->flat_number) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Area (sq.ft)</label>
                            <input type="number" step="0.01" name="area" class="form-control" value="{{ old('area', $flat->area) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $flat->price) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                @foreach (['available', 'reserved', 'booked', 'sold'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $flat->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('flats.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
