@extends('layouts.app')

@section('title', 'Vendors')

@section('content')
    <x-page-header title="Vendors" subtitle="Suppliers and material vendors">
        <x-slot:actions>
            <a href="{{ route('vendors.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Vendor</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Name</th><th>Contact</th><th>GST Number</th><th class="text-center">POs</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            <tr>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->contact ?? '-' }}</td>
                                <td>{{ $vendor->gst_number ?? '-' }}</td>
                                <td class="text-center">{{ $vendor->purchase_orders_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vendor?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No vendors yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $vendors->links() }}</div>
@endsection
