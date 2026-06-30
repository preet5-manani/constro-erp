@extends('layouts.app')

@section('title', 'Revenue Analytics')

@section('content')
    <x-page-header title="Revenue Analytics" subtitle="Monthly collected revenue">
        <x-slot:actions>
            <a href="{{ route('reports.index') }}" class="btn btn-border btn-round">Back</a>
        </x-slot:actions>
    </x-page-header>

    <div class="card card-round">
        <div class="card-body">
            @if (count($monthly))
                <div class="chart-container" style="min-height: 360px">
                    <canvas id="revenueChart"></canvas>
                </div>
            @else
                <p class="text-center text-muted py-5 mb-0">No payment data yet. Revenue appears here once payments with a paid date are recorded.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        var data = @json($monthly);
        var ctx = document.getElementById('revenueChart');
        if (!ctx || !Object.keys(data).length) return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Revenue',
                    data: Object.values(data),
                    borderColor: '#1572e8',
                    backgroundColor: 'rgba(23, 125, 255, 0.14)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    })();
</script>
@endpush
