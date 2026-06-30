@props([
    'label' => '',
    'value' => '',
    'icon' => 'fas fa-chart-bar',
    'color' => 'primary',
])

<div class="card card-stats card-round">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-icon">
                <div class="icon-big text-center icon-{{ $color }} bubble-shadow-small">
                    <i class="{{ $icon }}"></i>
                </div>
            </div>
            <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                    <p class="card-category">{{ $label }}</p>
                    <h4 class="card-title">{{ $value }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
