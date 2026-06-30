@extends('layouts.app')

@section('title', 'Booking #' . $booking->id)

@section('content')
    <x-page-header :title="'Booking #' . $booking->id" :subtitle="$booking->customer->name ?? ''">
        <x-slot:actions>
            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary btn-round"><i class="fa fa-edit"></i> Edit</a>
            <a href="{{ route('bookings.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-md-4"><x-stat-card label="Flat" :value="$booking->flat->flat_number ?? '-'" icon="fas fa-key" color="primary" /></div>
        <div class="col-md-4"><x-stat-card label="Token Amount" :value="number_format($booking->token_amount, 2)" icon="fas fa-coins" color="success" /></div>
        <div class="col-md-4"><x-stat-card label="Status" :value="ucfirst($booking->status)" icon="fas fa-info-circle" color="info" /></div>
    </div>

    <div class="card card-round">
        <div class="card-header"><div class="card-title">Installments</div></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>#</th><th class="text-end">Amount</th><th>Due Date</th><th>Status</th><th class="text-end">Paid</th></tr></thead>
                    <tbody>
                        @forelse ($booking->installments as $installment)
                            <tr>
                                <td>{{ $installment->id }}</td>
                                <td class="text-end">{{ number_format($installment->amount, 2) }}</td>
                                <td>{{ optional($installment->due_date)->format('d M Y') ?? '-' }}</td>
                                <td class="text-capitalize">{{ $installment->status }}</td>
                                <td class="text-end">{{ number_format($installment->payments->sum('amount'), 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No installments. Add them from the Installments section.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
