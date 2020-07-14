@include('layouts.header')

<body>
@auth
@include('layouts.navbar')
@endauth

    <!-- Page content -->
    <div class="page-content pt-2">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                @yield('content')

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

@include('layouts.footer')

</body>

</html>

@yield('extra-script')