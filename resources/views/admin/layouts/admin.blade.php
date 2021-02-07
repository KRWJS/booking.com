<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title', 'Admin') | Booking CMS</title>

    <!-- Styles -->
    <link href="{{ asset(cached_asset('css/admin.min.css')) }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    @section('body')

        @include('admin.partials.header')
        <main class="container l-inset-xxl-top">@yield('content')</main>
        @include('admin.partials.footer')

    @show

    <script src="{{ asset(cached_asset('js/admin.min.js')) }}"></script>
    @stack('scripts')
</body>
</html>
