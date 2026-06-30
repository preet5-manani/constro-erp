@extends('layouts.app')

@section('title', $booking->exists ? 'Edit Booking' : 'Add Booking')

@section('content')
    <x-page-header :title="$booking->exists ? 'Edit Booking' : 'Add Booking'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $booking->exists ? route('bookings.update', $booking) : route('bookings.store') }}">
                @csrf
                @if ($booking->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">-- Select customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id', $booking->customer_id) == $customer->id)>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Flat</label>
                            <select name="flat_id" class="form-select" required>
                                <option value="">-- Select flat --</option>
                                @foreach ($flats as $flat)
                                    <option value="{{ $flat->id }}" @selected(old('flat_id', $booking->flat_id) == $flat->id)>
                                        {{ $flat->flat_number }} - {{ $flat->floor->tower->name ?? '-' }} ({{ ucfirst($flat->status) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Booking Date</label>
                            <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date', optional($booking->booking_date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Token Amount</label>
                            <input type="number" step="0.01" name="token_amount" class="form-control" value="{{ old('token_amount', $booking->token_amount) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control" value="{{ old('status', $booking->status ?? 'pending') }}" required>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('bookings.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
