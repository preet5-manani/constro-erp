@extends('layouts.app')

@section('title', 'Contractor Payments')

@section('content')
    <x-page-header title="Contractor Payments" subtitle="Payouts to subcontractors">
        <x-slot:actions>
            <a href="{{ route('contractor-payments.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Payment</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Contractor</th><th class="text-end">Amount</th><th>Date</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($contractorPayments as $payment)
                            <tr>
                                <td>{{ $payment->contractor->name ?? '-' }}</td>
                                <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ optional($payment->date)->format('d M Y') ?? '-' }}</td>
                                <td class="text-capitalize">{{ $payment->status }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('contractor-payments.edit', $payment) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('contractor-payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this payment?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No contractor payments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $contractorPayments->links() }}</div>
@endsection
