@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <x-page-header title="Edit User" subtitle="{{ $user->email }}" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('users._form')
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
