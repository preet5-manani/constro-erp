@extends('layouts.app')

@section('title', 'Flats')

@section('content')
    <x-page-header title="Flats" subtitle="Units and their availability">
        <x-slot:actions>
            <a href="{{ route('flats.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Flat</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Flat #</th><th>Tower / Floor</th><th class="text-end">Area</th><th class="text-end">Price</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @php($badges = ['available' => 'success', 'reserved' => 'warning', 'booked' => 'info', 'sold' => 'danger'])
                        @forelse ($flats as $flat)
                            <tr>
                                <td>{{ $flat->flat_number }}</td>
                                <td>{{ $flat->floor->tower->name ?? '-' }} / F{{ $flat->floor->floor_number ?? '-' }}</td>
                                <td class="text-end">{{ $flat->area ? number_format($flat->area, 2) : '-' }}</td>
                                <td class="text-end">{{ number_format($flat->price, 2) }}</td>
                                <td><span class="badge badge-{{ $badges[$flat->status] ?? 'secondary' }} text-capitalize">{{ $flat->status }}</span></td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('flats.edit', $flat) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('flats.destroy', $flat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this flat?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No flats yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $flats->links() }}</div>
@endsection
