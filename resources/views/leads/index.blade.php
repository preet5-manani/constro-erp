@extends('layouts.app')

@section('title', 'Leads')

@section('content')
    <x-page-header title="Leads" subtitle="Sales pipeline">
        <x-slot:actions>
            <a href="{{ route('leads.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Lead</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Customer</th><th>Source</th><th>Status</th><th>Assigned To</th><th class="text-center">Visits</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @php($badges = ['new' => 'secondary', 'contacted' => 'info', 'visited' => 'primary', 'interested' => 'success', 'lost' => 'danger'])
                        @forelse ($leads as $lead)
                            <tr>
                                <td>{{ $lead->customer->name ?? 'Unlinked' }}</td>
                                <td>{{ $lead->source ?? '-' }}</td>
                                <td><span class="badge badge-{{ $badges[$lead->status] ?? 'secondary' }} text-capitalize">{{ $lead->status }}</span></td>
                                <td>{{ $lead->assignee->name ?? '-' }}</td>
                                <td class="text-center">{{ $lead->site_visits_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('leads.edit', $lead) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lead?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No leads yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $leads->links() }}</div>
@endsection
