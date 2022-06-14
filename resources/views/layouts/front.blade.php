<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="chrome">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ getCurrentGitCommitHash() }}">
</head>


<body>
<!-- Header Container -->
@include('front.partials.header')

@yield('content')

@include('front.partials.footer')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
@yield('scripts')
</body>
</html>
