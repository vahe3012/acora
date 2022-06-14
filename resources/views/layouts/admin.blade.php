<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('fonts/googleapis/fonts.googleapis.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">


    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom_admin.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

    <!-- Scripts -->
    <script>
        window._configs = {
            locale: '{{app()->getLocale()}}',
            csrf: "{{ csrf_token() }}"
        }
    </script>

    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="height: auto;">
<div class="wrapper" id="admin">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset("/images/acora-logo.png")}}" alt="AcoraLogo" height="60" width="200">
    </div>

    <!-- Header Container -->
@include('admin.partials.header')


<!-- Main Sidebar Container -->
@include('admin.partials.sidebar')

@yield('content')

</div>

<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>

<!-- Theme style -->
<script src="{{asset('js/adminlte.min.js')}}"></script>

<!-- Scripts -->
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('dist/admin/js/admin.js') }}"></script>
<script src="{{asset('js/table.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/js/moment.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('js/jquery-ui.min.js')}}"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button)

    $(document).ready(function () {
        @if (session('error'))
            @if (is_array(session('error')))
                @foreach(session('error') as $error)
                    toastr.error('{{$error}}', 'Something went wrong', {timeOut: 20000})
                @endforeach
            @else
                toastr.error('{{session('error')}}', 'Something went wrong', {timeOut: 20000})
            @endif
        @endif

        @if (session('success'))
            toastr.success('{{session('success')}}', {timeOut: 20000})
        @endif

        @if (session('errors'))
            @foreach (session('errors')->getMessages() as $key => $value)
                toastr.error('{{$value[0]}}', 'Validation Error', {timeOut: 20000})
            @endforeach
        @endif
    })

</script>

@yield('scripts')
@stack('scripts')

</body>
</html>
