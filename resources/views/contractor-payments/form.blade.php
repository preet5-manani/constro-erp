@extends('layouts.app')

@section('title', $contractorPayment->exists ? 'Edit Payment' : 'Add Contractor Payment')

@section('content')
    <x-page-header :title="$contractorPayment->exists ? 'Edit Payment' : 'Add Contractor Payment'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $contractorPayment->exists ? route('contractor-payments.update', $contractorPayment) : route('contractor-payments.store') }}">
                @csrf
                @if ($contractorPayment->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contractor</label>
                            <select name="contractor_id" class="form-select" required>
                                <option value="">-- Select contractor --</option>
                                @foreach ($contractors as $contractor)
                                    <option value="{{ $contractor->id }}" @selected(old('contractor_id', $contractorPayment->contractor_id) == $contractor->id)>{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $contractorPayment->amount) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', optional($contractorPayment->date)->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control" value="{{ old('status', $contractorPayment->status ?? 'pending') }}" required>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('contractor-payments.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
