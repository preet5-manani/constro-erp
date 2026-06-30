@extends('layouts.app')

@section('title', $contractor->exists ? 'Edit Contractor' : 'Add Contractor')

@section('content')
    <x-page-header :title="$contractor->exists ? 'Edit Contractor' : 'Add Contractor'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $contractor->exists ? route('contractors.update', $contractor) : route('contractors.store') }}">
                @csrf
                @if ($contractor->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $contractor->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Specialization</label>
                            <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $contractor->specialization) }}" placeholder="Plumbing, Electrical...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $contractor->phone) }}">
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('contractors.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
