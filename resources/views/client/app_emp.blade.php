<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ page_title($titre ?? null) }}</title>

@include('includes/css')


@include('includes/errors')

@if (!Session::has('user'))
    <script>
    window.location = "/";
  </script>
@endif


</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('includes/navbar')
        <!-- /.navbar -->

    <!-- Main Sidebar Container -->
        @include('includes/main_sidebar_emp')
    <!-- /. Main Sidebar Container -->



    <!-- Content Wrapper. Contains page content -->
        @yield('contenu')
    <!-- /.content-wrapper -->



    @include('includes/footer')
    
    
    <!-- Page specific script -->
    @yield('customjavascript')

    
</body>
</html>
