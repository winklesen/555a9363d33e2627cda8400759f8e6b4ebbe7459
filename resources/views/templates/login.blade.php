<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title')</title>
    <link href="{{ asset('vendor/tabler/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/demo.min.css?1692870487') }}" rel="stylesheet"/>
  </head>
  <body class="d-flex flex-column bg-white">
    <script src="{{ asset('vendor/tabler/dist/js/demo-theme.min.js?1692870487') }}"></script>
    <div class="page page-center">
      @yield('pages')
    </div>
    <script src="{{ asset('vendor/tabler/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('vendor/tabler/dist/js/demo.min.js?1692870487') }}" defer></script>
  </body>
</html>