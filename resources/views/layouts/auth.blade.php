<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Login') &middot; {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('kaiadmin-lite/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('kaiadmin-lite/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kaiadmin-lite/assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kaiadmin-lite/assets/css/kaiadmin.min.css') }}">

    <style>
        body.auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a2035 0%, #1572e8 100%);
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25);
        }
        .auth-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #1572e8;
        }
    </style>
</head>
<body class="auth-page">
    <div class="auth-card card">
        <div class="card-body p-4 p-md-5">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('kaiadmin-lite/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin-lite/assets/js/core/bootstrap.min.js') }}"></script>
</body>
</html>
