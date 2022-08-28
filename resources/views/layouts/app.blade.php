<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <!--<link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.css') }}">--> 
        <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
        <!--<link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">-->

<!--        <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/loading-bar.css') }}">-->

        @if(\Auth::user()->color_mode == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/white_mode.css') }}">
        @elseif(\Auth::user()->color_mode == 2)
        <link rel="stylesheet" href="{{ asset('assets/css/dark_mode.css') }}">
        @endif

        <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
        <!--<link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg" type="image/x-icon') }}">-->

        <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

        <link href="{{ asset('assets/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <style>
            .text-right{
                text-align: right;
            }
            .sidebar-wrapper .menu{
                margin-top: 0px; 
            }
            .sidebar-wrapper .menu .sidebar-item {
                margin-top: 0px; 
            }
            table.dataTable td {
                padding: 3px 8px;
            }
        </style>
    </head>
    <body>

        <div id="app">

            @include('layouts.sidebar')

            <div id="main">

                @include('layouts.header')

                {{ $slot }}

                @include('layouts.footer')

            </div>

        </div>

        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>

        <script>
var url_gb = `{{url('')}}`;
var asset_gb = `{{asset('')}}`;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

        </script>

        <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>

        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

        <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>

        <script src="{{ asset('assets/js/mazer.js') }}"></script>

        <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>

        <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/daterangepicker/daterangepicker.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    </body>
</html>
