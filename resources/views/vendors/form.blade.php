@extends('layouts.app')

@section('title', $vendor->exists ? 'Edit Vendor' : 'Add Vendor')

@section('content')
    <x-page-header :title="$vendor->exists ? 'Edit Vendor' : 'Add Vendor'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $vendor->exists ? route('vendors.update', $vendor) : route('vendors.store') }}">
                @csrf
                @if ($vendor->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $vendor->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="contact" class="form-control" value="{{ old('contact', $vendor->contact) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>GST Number</label>
                            <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number', $vendor->gst_number) }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $vendor->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('vendors.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
