@extends('layouts.app')

@section('title', $lead->exists ? 'Edit Lead' : 'Add Lead')

@section('content')
    <x-page-header :title="$lead->exists ? 'Edit Lead' : 'Add Lead'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $lead->exists ? route('leads.update', $lead) : route('leads.store') }}">
                @csrf
                @if ($lead->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer</label>
                            <select name="customer_id" class="form-select">
                                <option value="">-- Unlinked --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id', $lead->customer_id) == $customer->id)>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Source</label>
                            <input type="text" name="source" class="form-control" value="{{ old('source', $lead->source) }}" placeholder="Website, referral, walk-in...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                @foreach (['new', 'contacted', 'visited', 'interested', 'lost'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $lead->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Assigned To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">-- Unassigned --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to', $lead->assigned_to) == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
