@extends('layouts.app')

@section('title', 'Bookings')

@section('content')
    <x-page-header title="Bookings" subtitle="Flat bookings and reservations">
        <x-slot:actions>
            <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Booking</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Customer</th><th>Flat</th><th>Date</th><th class="text-end">Token</th><th>Status</th><th class="text-center">Installments</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->customer->name ?? '-' }}</td>
                                <td>{{ $booking->flat->flat_number ?? '-' }} ({{ $booking->flat->floor->tower->name ?? '-' }})</td>
                                <td>{{ optional($booking->booking_date)->format('d M Y') ?? '-' }}</td>
                                <td class="text-end">{{ number_format($booking->token_amount, 2) }}</td>
                                <td class="text-capitalize">{{ $booking->status }}</td>
                                <td class="text-center">{{ $booking->installments_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-icon btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this booking?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No bookings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $bookings->links() }}</div>
@endsection
