@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-page-header title="Dashboard" subtitle="Real Estate Management System overview" />

    <div class="row">
        <div class="col-sm-6 col-md-3">
            <x-stat-card label="Projects" :value="$stats['projects']" icon="fas fa-project-diagram" color="primary" />
        </div>
        <div class="col-sm-6 col-md-3">
            <x-stat-card label="Customers" :value="$stats['customers']" icon="fas fa-users" color="info" />
        </div>
        <div class="col-sm-6 col-md-3">
            <x-stat-card label="Flats Sold" :value="$stats['flats_sold']" icon="fas fa-key" color="success" />
        </div>
        <div class="col-sm-6 col-md-3">
            <x-stat-card label="Pending POs" :value="$stats['pending_pos']" icon="fas fa-file-invoice-dollar" color="secondary" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <x-stat-card label="Active Leads" :value="$stats['active_leads']" icon="fas fa-handshake" color="primary" />
        </div>
        <div class="col-md-4">
            <x-stat-card label="Bookings" :value="$stats['bookings']" icon="fas fa-bookmark" color="info" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Inventory by Status</div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 320px">
                        <canvas id="flatStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Flat Status Breakdown</div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($flatStatusCounts as $status => $total)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-capitalize">{{ $status }}</span>
                                <span class="badge badge-primary">{{ $total }}</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">No flats yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const ctx = document.getElementById('flatStatusChart');
        if (!ctx) return;
        const data = @json($flatStatusCounts);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Flats',
                    data: Object.values(data),
                    backgroundColor: ['#177dff', '#ffa534', '#f3545d', '#31ce36', '#6861ce']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    })();
</script>
@endpush
