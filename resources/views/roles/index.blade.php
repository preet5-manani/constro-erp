@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <x-page-header title="Roles" subtitle="Define roles and assign permissions">
        <x-slot:actions>
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-round">
                <i class="fa fa-plus"></i> Add Role
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
                            <th class="text-center">Permissions</th>
                            <th class="text-center">Users</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td class="text-center"><span class="badge badge-info">{{ $role->permissions_count }}</span></td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $role->users_count }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-icon btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if ($role->name !== 'Super Admin')
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No roles found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $roles->links() }}</div>
@endsection
