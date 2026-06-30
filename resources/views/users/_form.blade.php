@php($user = $user ?? null)

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control"
                   value="{{ old('name', $user->name ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                   value="{{ old('email', $user->email ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password {{ $user ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" id="password" name="password" class="form-control"
                   {{ $user ? '' : 'required' }}>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="d-block">Roles</label>
            @forelse ($roles as $role)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="roles[]"
                           id="role_{{ $role->id }}" value="{{ $role->name }}"
                           {{ in_array($role->name, old('roles', $userRoles ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @empty
                <p class="text-muted">No roles available. Create one first.</p>
            @endforelse
        </div>
    </div>
</div>
