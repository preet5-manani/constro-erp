@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <x-page-header title="Customers" subtitle="Customer directory">
        <x-slot:actions>
            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Customer</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="thead-light"><tr><th>Name</th><th>Email</th><th>Phone</th><th class="text-center">Leads</th><th class="text-center">Bookings</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email ?? '-' }}</td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td class="text-center">{{ $customer->leads_count }}</td>
                                <td class="text-center">{{ $customer->bookings_count }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-icon btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this customer?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-icon btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No customers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $customers->links() }}</div>
@endsection
