@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    <x-page-header title="Attendance" subtitle="Daily contractor attendance">
        <x-slot:actions>
            <a href="{{ route('attendances.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Mark Attendance</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Contractor</th><th>Date</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->contractor->name ?? '-' }}</td>
                                <td>{{ optional($attendance->date)->format('d M Y') }}</td>
                                <td><span class="badge badge-{{ $attendance->status === 'present' ? 'success' : 'danger' }} text-capitalize">{{ $attendance->status }}</span></td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No attendance records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $attendances->links() }}</div>
@endsection
