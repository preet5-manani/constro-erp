@extends('layouts.app')

@section('title', $customer->exists ? 'Edit Customer' : 'Add Customer')

@section('content')
    <x-page-header :title="$customer->exists ? 'Edit Customer' : 'Add Customer'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}">
                @csrf
                @if ($customer->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $customer->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
