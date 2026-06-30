@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <x-page-header title="Edit Permission" subtitle="{{ $permission->name }}" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ route('permissions.update', $permission) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="{{ old('name', $permission->name) }}" required>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Update Permission</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
