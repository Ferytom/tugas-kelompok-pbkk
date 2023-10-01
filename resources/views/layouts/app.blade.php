<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>

    {{-- <link rel="shortcut icon" href="{{ asset('assets/img/fav.png') }}" type="image/x-icon"> --}}

    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">

    {{-- @vite(['resources/css/app.css']) --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <style>
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select,
        textarea {
            border: 2px solid #509f67;
        }
    </style>
</head>

<body class="bg-gray-100">


    <!-- start navbar -->
    @include('layouts.navbar')
    <!-- end navbar -->


    <!-- strat wrapper -->
    <div class="h-screen flex flex-row flex-wrap">

        <!-- start sidebar -->
        @include('layouts.sidebar')
        <!-- end sidbar -->

        <!-- strat content -->
        <div class="bg-gray-100 flex-1 p-6 md:mt-16">
            @yield('content')
        </div>
        <!-- end content -->

    </div>
    <!-- end wrapper -->

    <!-- script -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- end script -->

</body>

</html>
