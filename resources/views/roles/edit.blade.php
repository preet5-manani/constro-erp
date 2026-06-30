@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <x-page-header title="Edit Role" subtitle="{{ $role->name }}" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $role) }}">
                @csrf
                @method('PUT')
                @include('roles._form')
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Update Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
