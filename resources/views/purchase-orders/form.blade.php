@extends('layouts.app')

@section('title', $order->exists ? 'Edit Purchase Order' : 'New Purchase Order')

@section('content')
    <x-page-header :title="$order->exists ? 'Edit Purchase Order #' . $order->id : 'New Purchase Order'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $order->exists ? route('purchase-orders.update', $order) : route('purchase-orders.store') }}">
                @csrf
                @if ($order->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Vendor</label>
                            <select name="vendor_id" class="form-select" required>
                                <option value="">-- Select vendor --</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" @selected(old('vendor_id', $order->vendor_id) == $vendor->id)>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                @foreach (['draft', 'pending', 'approved', 'rejected'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="">-- None --</option>
                                @foreach (['cash', 'cheque', 'upi', 'bank_transfer'] as $method)
                                    <option value="{{ $method }}" @selected(old('payment_method', $order->payment_method) === $method)>{{ ucwords(str_replace('_', ' ', $method)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold mb-3">Line Items</h5>
                <div class="table-responsive">
                    <table class="table" id="itemsTable">
                        <thead>
                            <tr><th style="width:40%">Item</th><th>Qty</th><th>Unit Price</th><th>GST %</th><th></th></tr>
                        </thead>
                        <tbody>
                            @php($items = old('items', $order->exists ? $order->items->toArray() : [['item_name' => '', 'quantity' => 1, 'unit_price' => 0, 'gst' => 0]]))
                            @foreach ($items as $i => $item)
                                <tr>
                                    <td><input type="text" name="items[{{ $i }}][item_name]" data-field="item_name" class="form-control" value="{{ $item['item_name'] ?? '' }}"></td>
                                    <td><input type="number" step="0.01" name="items[{{ $i }}][quantity]" data-field="quantity" class="form-control" value="{{ $item['quantity'] ?? 1 }}"></td>
                                    <td><input type="number" step="0.01" name="items[{{ $i }}][unit_price]" data-field="unit_price" class="form-control" value="{{ $item['unit_price'] ?? 0 }}"></td>
                                    <td><input type="number" step="0.01" name="items[{{ $i }}][gst]" data-field="gst" class="form-control" value="{{ $item['gst'] ?? 0 }}"></td>
                                    <td><button type="button" class="btn btn-icon btn-sm btn-danger remove-row"><i class="fa fa-times"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-label-info" id="addRow"><i class="fa fa-plus"></i> Add Item</button>

                <div class="card-action mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('purchase-orders.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        var table = document.querySelector('#itemsTable tbody');
        function reindex() {
            Array.prototype.forEach.call(table.rows, function (row, idx) {
                row.querySelectorAll('input[data-field]').forEach(function (input) {
                    input.name = 'items[' + idx + '][' + input.dataset.field + ']';
                });
            });
        }
        document.getElementById('addRow').addEventListener('click', function () {
            var row = table.rows[0].cloneNode(true);
            row.querySelectorAll('input').forEach(function (i) { i.value = i.type === 'number' ? 0 : ''; });
            table.appendChild(row);
            reindex();
        });
        table.addEventListener('click', function (e) {
            if (e.target.closest('.remove-row') && table.rows.length > 1) {
                e.target.closest('tr').remove();
                reindex();
            }
        });
        reindex();
    })();
</script>
@endpush
