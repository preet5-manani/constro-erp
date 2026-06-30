@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <x-page-header title="Settings" subtitle="Application configuration (key / value)" />

    <div class="row">
        <div class="col-md-5">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Add / Update Setting</div></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Key</label>
                            <input type="text" name="key" class="form-control" value="{{ old('key') }}" placeholder="e.g. company_name" required>
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <textarea name="value" class="form-control" rows="2">{{ old('value') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Setting</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Current Settings</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light"><tr><th>Key</th><th>Value</th><th class="text-end">Actions</th></tr></thead>
                            <tbody>
                                @forelse ($settings as $setting)
                                    <tr>
                                        <td class="fw-bold">{{ $setting->key }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('settings.update', $setting) }}" class="d-flex gap-2">
                                                @csrf @method('PUT')
                                                <input type="text" name="value" class="form-control form-control-sm" value="{{ $setting->value }}">
                                                <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                            </form>
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('settings.destroy', $setting) }}" method="POST" onsubmit="return confirm('Delete this setting?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center py-4 text-muted">No settings defined yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
