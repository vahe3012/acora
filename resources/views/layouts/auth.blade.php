<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('fonts/googleapis/fonts.googleapis.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">


{{--    <!-- DataTables -->??????--}}
{{--    <link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css">--}}
{{--    <link rel="stylesheet" href="/css/responsive.bootstrap4.min.css">--}}

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Styles -->
{{--    <link href="{{ asset('css/main.css') }}" rel="stylesheet">--}}
</head>
<body class="hold-transition login-page">

<div id="admin">

    @yield('content')

</div>

<!-- Scripts -->


<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<!-- ???? Resolve conflict in jQuery UI tooltip with Bootstrap tooltip ??????-->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


<script src="{{ asset('dist/admin/js/admin.js') }}"></script>
{{--<!-- DataTables  & Plugins -->--}}
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/responsive.bootstrap4.min.js')}}"></script>
</body>
</html>
