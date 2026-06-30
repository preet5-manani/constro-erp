@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
    <x-page-header title="Permissions" subtitle="Granular permissions assignable to roles">
        <x-slot:actions>
            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-round">
                <i class="fa fa-plus"></i> Add Permission
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
                            <th class="text-center">Roles</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td class="text-center"><span class="badge badge-info">{{ $permission->roles_count }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-icon btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this permission?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">No permissions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $permissions->links() }}</div>
@endsection
