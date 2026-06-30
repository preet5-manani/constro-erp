@extends('layouts.app')

@section('title', 'Site Visits')

@section('content')
    <x-page-header title="Site Visits" subtitle="Scheduled and completed visits">
        <x-slot:actions>
            <a href="{{ route('site-visits.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Record Visit</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Lead / Customer</th><th>Visit Date</th><th>Feedback</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($siteVisits as $visit)
                            <tr>
                                <td>{{ $visit->lead->customer->name ?? 'Lead #' . $visit->lead_id }}</td>
                                <td>{{ optional($visit->visit_date)->format('d M Y, H:i') ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($visit->feedback, 60) ?: '-' }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('site-visits.edit', $visit) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('site-visits.destroy', $visit) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this visit?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No site visits yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $siteVisits->links() }}</div>
@endsection
