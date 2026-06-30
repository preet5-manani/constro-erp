@extends('layouts.app')

@section('title', $payment->exists ? 'Edit Payment' : 'Record Payment')

@section('content')
    <x-page-header :title="$payment->exists ? 'Edit Payment' : 'Record Payment'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $payment->exists ? route('payments.update', $payment) : route('payments.store') }}">
                @csrf
                @if ($payment->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Installment</label>
                            <select name="installment_id" class="form-select" required>
                                <option value="">-- Select installment --</option>
                                @foreach ($installments as $installment)
                                    <option value="{{ $installment->id }}" @selected(old('installment_id', $payment->installment_id) == $installment->id)>
                                        #{{ $installment->id }} - {{ $installment->booking->customer->name ?? '-' }} ({{ number_format($installment->amount, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Method</label>
                            <select name="method" class="form-select">
                                @foreach (['cash', 'cheque', 'upi', 'bank_transfer'] as $method)
                                    <option value="{{ $method }}" @selected(old('method', $payment->method) === $method)>{{ ucwords(str_replace('_', ' ', $method)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Transaction Reference</label>
                            <input type="text" name="transaction_ref" class="form-control" value="{{ old('transaction_ref', $payment->transaction_ref) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Paid At</label>
                            <input type="date" name="paid_at" class="form-control" value="{{ old('paid_at', optional($payment->paid_at)->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
