<!doctype html>
<html lang="{{App::getLocale()}}">
    <head>
    @include('layouts/partials/header')
    </head>
    <body class="hold-transition sidebar-mini" >
    <div class="wrapper" id="app">
        @include('layouts/partials/navbar')
        @include('layouts/partials/sidebar')
        <div class="content-wrapper" id="app">
            <!-- Main content -->
            <div class="content">
            <!-- container-fluid -->
            <div class="container-fluid">
                <router-view></router-view>
            </div>
            <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts/partials/footer')
    </div>
        @include('layouts/partials/script')
        @yield('script')
    </body>
</html>
