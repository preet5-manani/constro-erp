@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
    <x-page-header title="Purchase Orders" subtitle="Procurement and approvals">
        <x-slot:actions>
            <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> New Order</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>PO #</th><th>Vendor</th><th>Status</th><th>Payment</th><th class="text-end">Total</th><th>Approved By</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @php($badges = ['draft' => 'secondary', 'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'])
                        @forelse ($orders as $order)
                            <tr>
                                <td><a href="{{ route('purchase-orders.show', $order) }}">#{{ $order->id }}</a></td>
                                <td>{{ $order->vendor->name ?? '-' }}</td>
                                <td><span class="badge badge-{{ $badges[$order->status] ?? 'secondary' }} text-capitalize">{{ $order->status }}</span></td>
                                <td class="text-capitalize">{{ $order->payment_method ? str_replace('_', ' ', $order->payment_method) : '-' }}</td>
                                <td class="text-end">{{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->approver->name ?? '-' }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('purchase-orders.show', $order) }}" class="btn btn-icon btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('purchase-orders.edit', $order) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('purchase-orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No purchase orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
@endsection
