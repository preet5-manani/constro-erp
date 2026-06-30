<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Dashboard') &middot; {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('kaiadmin-lite/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <script src="{{ asset('kaiadmin-lite/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["{{ asset('kaiadmin-lite/assets/css/fonts.min.css') }}"]
            },
            active: function () { sessionStorage.fonts = true; }
        });
    </script>

    <link rel="stylesheet" href="{{ asset('kaiadmin-lite/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kaiadmin-lite/assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kaiadmin-lite/assets/css/kaiadmin.min.css') }}">
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('dashboard') }}" class="logo">
                            <span class="fw-bold text-white fs-4">REMS</span>
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                </div>
                @include('partials.navbar')
            </div>

            <div class="container">
                <div class="page-inner">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            @include('partials.footer')
        </div>
    </div>

    <script src="{{ asset('kaiadmin-lite/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/kaiadmin.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
