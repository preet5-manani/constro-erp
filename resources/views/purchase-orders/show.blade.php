@extends('layouts.app')

@section('title', 'Purchase Order #' . $order->id)

@section('content')
    @php($badges = ['draft' => 'secondary', 'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'])
    <x-page-header :title="'Purchase Order #' . $order->id" :subtitle="$order->vendor->name ?? ''">
        <x-slot:actions>
            <a href="{{ route('purchase-orders.edit', $order) }}" class="btn btn-primary btn-round"><i class="fa fa-edit"></i> Edit</a>
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header"><div class="card-title">Items</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light"><tr><th>Item</th><th class="text-end">Qty</th><th class="text-end">Unit Price</th><th class="text-end">GST %</th><th class="text-end">Total</th></tr></thead>
                            <tbody>
                                @forelse ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->item_name }}</td>
                                        <td class="text-end">{{ number_format($item->quantity, 2) }}</td>
                                        <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-end">{{ number_format($item->gst, 2) }}</td>
                                        <td class="text-end">{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">No items.</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr><th colspan="4" class="text-end">Total</th><th class="text-end">{{ number_format($order->total_amount, 2) }}</th></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge badge-{{ $badges[$order->status] ?? 'secondary' }} text-capitalize">{{ $order->status }}</span></p>
                    <p><strong>Vendor:</strong> {{ $order->vendor->name ?? '-' }}</p>
                    <p><strong>Payment Method:</strong> {{ $order->payment_method ? ucwords(str_replace('_', ' ', $order->payment_method)) : '-' }}</p>
                    <p class="mb-0"><strong>Approved By:</strong> {{ $order->approver->name ?? 'Pending' }}</p>

                    @can('approve purchase')
                        @if (in_array($order->status, ['draft', 'pending']))
                            <hr>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('purchase-orders.approve', $order) }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approve</button>
                                </form>
                                <form method="POST" action="{{ route('purchase-orders.reject', $order) }}">
                                    @csrf
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Reject</button>
                                </form>
                            </div>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
