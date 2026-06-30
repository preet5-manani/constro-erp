@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
    <x-page-header title="Sales Report" subtitle="Bookings and payments">
        <x-slot:actions>
            <a href="{{ route('reports.export', 'sales') }}" class="btn btn-primary btn-round"><i class="fa fa-download"></i> Export CSV</a>
            <a href="{{ route('reports.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-header"><div class="card-title">Bookings ({{ $bookings->count() }})</div></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>#</th><th>Customer</th><th>Flat</th><th>Date</th><th class="text-end">Token</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($bookings as $b)
                            <tr>
                                <td>{{ $b->id }}</td>
                                <td>{{ $b->customer->name ?? '-' }}</td>
                                <td>{{ $b->flat->flat_number ?? '-' }}</td>
                                <td>{{ optional($b->booking_date)->format('d M Y') ?? '-' }}</td>
                                <td class="text-end">{{ number_format($b->token_amount, 2) }}</td>
                                <td class="text-capitalize">{{ $b->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No bookings.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-round">
        <div class="card-header"><div class="card-title">Payments ({{ $payments->count() }} &middot; Total {{ number_format($payments->sum('amount'), 2) }})</div></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Customer</th><th class="text-end">Amount</th><th>Method</th><th>Paid At</th></tr></thead>
                    <tbody>
                        @forelse ($payments as $p)
                            <tr>
                                <td>{{ $p->installment->booking->customer->name ?? '-' }}</td>
                                <td class="text-end">{{ number_format($p->amount, 2) }}</td>
                                <td class="text-capitalize">{{ str_replace('_', ' ', $p->method) }}</td>
                                <td>{{ optional($p->paid_at)->format('d M Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No payments.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
