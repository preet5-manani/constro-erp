@extends('layouts.app')

@section('title', 'Installments')

@section('content')
    <x-page-header title="Installments" subtitle="Payment schedule per booking">
        <x-slot:actions>
            <a href="{{ route('installments.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Installment</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Booking</th><th class="text-end">Amount</th><th>Due Date</th><th>Status</th><th class="text-center">Payments</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @php($badges = ['pending' => 'warning', 'paid' => 'success', 'overdue' => 'danger'])
                        @forelse ($installments as $installment)
                            <tr>
                                <td>#{{ $installment->booking_id }} - {{ $installment->booking->customer->name ?? '-' }}</td>
                                <td class="text-end">{{ number_format($installment->amount, 2) }}</td>
                                <td>{{ optional($installment->due_date)->format('d M Y') ?? '-' }}</td>
                                <td><span class="badge badge-{{ $badges[$installment->status] ?? 'secondary' }} text-capitalize">{{ $installment->status }}</span></td>
                                <td class="text-center">{{ $installment->payments_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('installments.edit', $installment) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('installments.destroy', $installment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this installment?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No installments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $installments->links() }}</div>
@endsection
