@extends('layouts.app')

@section('title', 'Add Role')

@section('content')
    <x-page-header title="Add Role" subtitle="Create a role and assign permissions" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                @include('roles._form', ['rolePermissions' => []])
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Create Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
