<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title')</title>
    <link href="{{ asset('vendor/tabler/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/demo.min.css?1692870487') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
      ::-webkit-resizer{
        display: none;
      }
    </style>
  </head>
  <body>
    <div class="page">
      @yield('sidebar')
      @include('templates.subtemplates.navbar')
      <div class="page-wrapper">
        <div class="page-header d-print-none">
          @yield('header')
        </div>
        <div class="page-body">
          @yield('pages')
        </div>
        @include('templates.subtemplates.footer')
      </div>
    </div>
    <script src="{{ asset('vendor/tabler/dist/libs/apexcharts/dist/apexcharts.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('vendor/tabler/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('vendor/tabler/dist/libs/jsvectormap/dist/maps/world.js?1692870487') }}" defer></script>
    <script src="{{ asset('vendor/tabler/dist/libs/jsvectormap/dist/maps/world-merc.js?1692870487') }}" defer></script>
    <script src="{{ asset('vendor/tabler/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('vendor/tabler/dist/js/demo.min.js?1692870487') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script>
      $(document).ready(function () {
        $('.number').on('input', function () {
          this.value = this.value.replace(/[^0-9]/g, '');
        });
      });
    </script>
  </body>
</html>