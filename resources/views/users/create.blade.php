@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <x-page-header title="Add User" subtitle="Create a new system user" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('users._form', ['userRoles' => []])
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
