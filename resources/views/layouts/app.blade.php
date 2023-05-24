<!DOCTYPE html>
<html lang="ru">
@include('components.head')

<body id="page-top">
    <div id="preloader" class="loader"></div>
    <div id="wrapper">
        @include('components.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('components.topbar')
                @include('components.alert')
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    @include('components.breadcrumbs')
                    <div class="row @yield('view')">
                        @yield('row')
                    </div>
                    <!--Row-->
                    @include('components.logout')
                </div>
                <!---Container Fluid-->
            </div>
            @include('components.footer')
            @yield('modal')
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script>
        window.Laravel = {!! json_encode([
        'user' => auth()->check() ? auth()->user()->id : null,
    ]) !!};
    </script>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
