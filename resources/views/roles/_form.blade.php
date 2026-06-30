@php($role = $role ?? null)

<div class="form-group">
    <label for="name">Role Name</label>
    <input type="text" id="name" name="name" class="form-control"
           value="{{ old('name', $role->name ?? '') }}" required>
</div>

<div class="form-group">
    <label class="d-block">Permissions</label>
    <div class="row">
        @forelse ($permissions as $permission)
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]"
                           id="perm_{{ $permission->id }}" value="{{ $permission->name }}"
                           {{ in_array($permission->name, old('permissions', $rolePermissions ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            </div>
        @empty
            <p class="text-muted">No permissions available. Create one first.</p>
        @endforelse
    </div>
</div>
