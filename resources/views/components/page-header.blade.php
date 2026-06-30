@props([
    'title' => '',
    'subtitle' => null,
])

<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-1">{{ $title }}</h3>
        @if ($subtitle)
            <h6 class="op-7 mb-2">{{ $subtitle }}</h6>
        @endif
    </div>
    @if (isset($actions))
        <div class="ms-md-auto py-2 py-md-0">
            {{ $actions }}
        </div>
    @endif
</div>
