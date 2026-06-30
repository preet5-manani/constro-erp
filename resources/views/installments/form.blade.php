@extends('layouts.app')

@section('title', $installment->exists ? 'Edit Installment' : 'Add Installment')

@section('content')
    <x-page-header :title="$installment->exists ? 'Edit Installment' : 'Add Installment'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $installment->exists ? route('installments.update', $installment) : route('installments.store') }}">
                @csrf
                @if ($installment->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Booking</label>
                            <select name="booking_id" class="form-select" required>
                                <option value="">-- Select booking --</option>
                                @foreach ($bookings as $booking)
                                    <option value="{{ $booking->id }}" @selected(old('booking_id', $installment->booking_id) == $booking->id)>
                                        #{{ $booking->id }} - {{ $booking->customer->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $installment->amount) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', optional($installment->due_date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                @foreach (['pending', 'paid', 'overdue'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $installment->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('installments.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
