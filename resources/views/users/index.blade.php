@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <x-page-header title="Users" subtitle="Manage system users and their roles">
        <x-slot:actions>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-round">
                <i class="fa fa-plus"></i> Add User
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->roles as $role)
                                        <span class="badge badge-info">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-muted">No roles</span>
                                    @endforelse
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-icon btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $users->links() }}</div>
@endsection
