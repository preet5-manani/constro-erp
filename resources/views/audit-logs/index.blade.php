@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
    <x-page-header title="Audit Logs" subtitle="Track all create, update and delete actions" />

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>When</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Model</th>
                            <th class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $log->user->name ?? 'System' }}</td>
                                <td>
                                    @php($badge = ['created' => 'success', 'updated' => 'warning', 'deleted' => 'danger'][$log->event] ?? 'secondary')
                                    <span class="badge badge-{{ $badge }}">{{ ucfirst($log->event) }}</span>
                                </td>
                                <td>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                                <td class="text-end">
                                    <a href="{{ route('audit-logs.show', $log) }}" class="btn btn-icon btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No audit records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $logs->links() }}</div>
@endsection
