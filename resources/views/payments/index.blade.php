@extends('layouts.app')

@section('title', 'Payments')

@section('content')
    <x-page-header title="Payments" subtitle="Recorded payment transactions">
        <x-slot:actions>
            <a href="{{ route('payments.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Record Payment</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Customer</th><th>Installment</th><th class="text-end">Amount</th><th>Method</th><th>Reference</th><th>Paid At</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->installment->booking->customer->name ?? '-' }}</td>
                                <td>#{{ $payment->installment_id }}</td>
                                <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                <td class="text-capitalize">{{ str_replace('_', ' ', $payment->method) }}</td>
                                <td>{{ $payment->transaction_ref ?? '-' }}</td>
                                <td>{{ optional($payment->paid_at)->format('d M Y') ?? '-' }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this payment?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No payments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $payments->links() }}</div>
@endsection
