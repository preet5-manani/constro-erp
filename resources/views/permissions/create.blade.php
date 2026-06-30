@extends('layouts.app')

@section('title', 'Add Permission')

@section('content')
    <x-page-header title="Add Permission" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="e.g. manage projects" required>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
