@extends('layouts.app')

@section('title', 'Audit Log Detail')

@section('content')
    <x-page-header title="Audit Log #{{ $auditLog->id }}"
                   subtitle="{{ ucfirst($auditLog->event) }} on {{ class_basename($auditLog->auditable_type) }} #{{ $auditLog->auditable_id }}">
        <x-slot:actions>
            <a href="{{ route('audit-logs.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><strong>User</strong><br>{{ $auditLog->user->name ?? 'System' }}</div>
                <div class="col-md-3"><strong>Date</strong><br>{{ $auditLog->created_at->format('d M Y, H:i:s') }}</div>
                <div class="col-md-3"><strong>IP Address</strong><br>{{ $auditLog->ip_address ?? '-' }}</div>
                <div class="col-md-3"><strong>Event</strong><br>{{ ucfirst($auditLog->event) }}</div>
            </div>
            @if ($auditLog->user_agent)
                <div class="mt-3"><strong>User Agent</strong><br><small class="text-muted">{{ $auditLog->user_agent }}</small></div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Old Values</div></div>
                <div class="card-body">
                    @if ($auditLog->old_values)
                        <table class="table table-sm">
                            <tbody>
                                @foreach ($auditLog->old_values as $key => $value)
                                    <tr><th>{{ $key }}</th><td>{{ is_array($value) ? json_encode($value) : $value }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">No previous values.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">New Values</div></div>
                <div class="card-body">
                    @if ($auditLog->new_values)
                        <table class="table table-sm">
                            <tbody>
                                @foreach ($auditLog->new_values as $key => $value)
                                    <tr><th>{{ $key }}</th><td>{{ is_array($value) ? json_encode($value) : $value }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">No new values.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
