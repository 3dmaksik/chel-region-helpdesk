<!DOCTYPE html>
<html lang="ru">
@include('components.head')

<body id="page-top">
  <div id="wrapper">
    @include('components.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('components.topbar')
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          @include('components.breadcrumbs')
          <div class="row">
            <div class="@yield('components.grid')">
    @yield('row')
    @yield('paginate')
            </div>
            <div class="@yield('components.grid.right')">
    @yield('row.right')
    @yield('paginate.right')
            </div>
          </div>
        <!--Row-->
    @include('components.logout')
        </div>
      <!---Container Fluid-->
      </div>
    @include('components.modal')
    @include('components.footer')
    </div>
  </div>
  <!-- ./wrapper -->
  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
