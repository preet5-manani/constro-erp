@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <x-page-header title="Reports" subtitle="Analytics and exports" />

    <div class="row">
        <div class="col-md-3"><x-stat-card label="Total Bookings" :value="$summary['total_bookings']" icon="fas fa-bookmark" color="primary" /></div>
        <div class="col-md-3"><x-stat-card label="Collected" :value="number_format($summary['total_collected'], 2)" icon="fas fa-coins" color="success" /></div>
        <div class="col-md-3"><x-stat-card label="Approved Purchase" :value="number_format($summary['total_purchase'], 2)" icon="fas fa-file-invoice-dollar" color="info" /></div>
        <div class="col-md-3"><x-stat-card label="Pending Purchase" :value="number_format($summary['pending_purchase'], 2)" icon="fas fa-hourglass-half" color="secondary" /></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body text-center">
                    <div class="icon-big icon-primary mb-3"><i class="fas fa-handshake"></i></div>
                    <h4 class="fw-bold">Sales Report</h4>
                    <p class="text-muted">Bookings and payment collections.</p>
                    <a href="{{ route('reports.sales') }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('reports.export', 'sales') }}" class="btn btn-label-info btn-sm"><i class="fa fa-download"></i> CSV</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body text-center">
                    <div class="icon-big icon-info mb-3"><i class="fas fa-shopping-cart"></i></div>
                    <h4 class="fw-bold">Purchase Report</h4>
                    <p class="text-muted">Purchase orders and approvals.</p>
                    <a href="{{ route('reports.purchase') }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('reports.export', 'purchase') }}" class="btn btn-label-info btn-sm"><i class="fa fa-download"></i> CSV</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body text-center">
                    <div class="icon-big icon-success mb-3"><i class="far fa-chart-bar"></i></div>
                    <h4 class="fw-bold">Revenue Analytics</h4>
                    <p class="text-muted">Monthly revenue trend.</p>
                    <a href="{{ route('reports.revenue') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
    </div>
@endsection
