@extends('layouts.app')

@section('title', 'Purchase Report')

@section('content')
    <x-page-header title="Purchase Report" subtitle="Purchase orders overview">
        <x-slot:actions>
            <a href="{{ route('reports.export', 'purchase') }}" class="btn btn-primary btn-round"><i class="fa fa-download"></i> Export CSV</a>
            <a href="{{ route('reports.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>PO #</th><th>Vendor</th><th>Status</th><th>Payment</th><th class="text-end">Total</th><th>Approved By</th></tr></thead>
                    <tbody>
                        @php($badges = ['draft' => 'secondary', 'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'])
                        @forelse ($orders as $o)
                            <tr>
                                <td>#{{ $o->id }}</td>
                                <td>{{ $o->vendor->name ?? '-' }}</td>
                                <td><span class="badge badge-{{ $badges[$o->status] ?? 'secondary' }} text-capitalize">{{ $o->status }}</span></td>
                                <td class="text-capitalize">{{ $o->payment_method ? str_replace('_', ' ', $o->payment_method) : '-' }}</td>
                                <td class="text-end">{{ number_format($o->total_amount, 2) }}</td>
                                <td>{{ $o->approver->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No purchase orders.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr><th colspan="4" class="text-end">Total</th><th class="text-end">{{ number_format($orders->sum('total_amount'), 2) }}</th><th></th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
