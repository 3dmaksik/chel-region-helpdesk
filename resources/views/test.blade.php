<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="_token" content="{{ csrf_token() }}"/>
        <meta http-equiv="refresh" content="600">
        <link href="/img/logo/logo.png" rel="icon">
        <title>Администрация Металлургического района - Панель заявки</title>
        <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    </head>
<body id="page-top">
<div id="wrapper">
    <!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion d-print-none" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/panel">
        <div class="sidebar-brand-icon">
            <img src="/img/logo/logo2.png">
        </div>
        <div class="sidebar-brand-text mx-3">Главные заявки</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="/panel">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Панель</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Списки
    </div>
    <li class="nav-item active">
        <a class="nav-link" href="/panel/category">
            <i class="fas fa-fw fa-angle-double-up"></i>
            <span>Категории</span>
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="/panel/status">
            <i class="fas fa-fw fa-star"></i>
            <span>Статусы</span>
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="/panel/cabinet">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Кабинеты</span>
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="/panel/work">
            <i class="fas fa-fw fa-user"></i>
            <span>Сотрудники</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Дополнительное
    </div>
    <li class="nav-item active">
        <a class="nav-link" href="/panel/stat">
            <i class="fas fa-fw fa-star"></i>
            <span>Статистика</span>
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="/panel/settings/edit/">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Настройки</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
	<div class="version">Страница обновлена в: 1 мин.</div>
</ul>
<!-- Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                 aria-labelledby="searchDropdown">
                 <form class="navbar-search" method="POST" action="search.viewSearch"></form>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-1 small is-invalid" placeholder="Введите ФИО или описание для поиска"
                               aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span id="counter" class="badge badge-danger badge-counter">1</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Оповещения
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="/panel/search/status/1">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div id="new_count" class="small text-gray-500">Новые заявки</div>
                        У вас новых заявок: 1
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="/panel/search/status/2">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-walking text-white"></i>
                        </div>
                    </div>

                    <div>
                        <div id="now_count" class="small text-gray-500">На исполнении</div>
                        У вас заявок на исполнении: 1
                    </div>
                </a>
            </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="/img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"> Имя</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/panel/settings/edit/">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                   Настройки
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Выход
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Журнал заявок</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Главная</a></li>
                    <li class="breadcrumb-item">Заявки</li>
                    <li class="breadcrumb-item active" aria-current="page">Журнал заявок</li>
                    <li id="breadcumb-panel" style="display: none">1</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Simple Tables -->
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Все заявки</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th style="width:5%">Номер</th>
                                    <th style="width:20%">Категория</th>
                                    <th style="width:1%;">Кабинет</th>
                                    <th style="width:20%">Сотрудник</th>
                                    <th style="width:12%">Дата подачи</th>
                                    <th style="width:12%">Дата выполнения</th>
                                    <th style="width:10%">Статус</th>
                                    <th class="d-print-none">Действие</th>
                                </tr>
                                </thead>
                                <tbody id="table-dynamic">
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>
                                        <div class="slider">
                                            <a href="/images/1669129307_1421404090.png" data-fancybox="images">
                                                <img src="/images/1669129307_1421404090.png" alt="" />
                                            </a>
                                            <a href="/images/1669129307_1421404090.png" data-fancybox="images">
                                                <img src="/images/1669129307_1421404090.png" alt="" />
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">1</span>
                                    </td>
                                    <td class="d-print-none">
                                        <div class="block">
                                            <a href="/panel/help/" class="btn btn-info btn-sm hover">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <span class="hidden">Просмотреть заявку</span> <!-- скрытый элемент -->
                                        </div>
                                        <div class="block">
                                          <a href="/panel/help/update/" class="btn btn-success btn-sm hover">
                                              <i class="fas fa-check"></i>
                                          </a>
                                          <span class="hidden">Взять заявку</span> <!-- скрытый элемент -->
                                        </div>
                                        <div class="block">
                                            <a href="" class="btn btn-danger btn-sm hover" data-toggle="modal" data-target="#closeHelp" data-id="1">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <span class="hidden">Отклонить заявку</span> <!-- скрытый элемент -->
                                        </div>
                                       <div class="block">
                                           <a href="" class="btn btn-success btn-sm hover" data-toggle="modal" data-target="#updateHelp" data-id="1">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <span class="hidden">Выполнить заявку</span> <!-- скрытый элемент -->
                                       </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Окно закрытия-->
<div class="modal fade" id="updateHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Закрыть заявку</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="update-form" action="help.closeHelp" method="POST">
            <div class="modal-body form-group">
                <label for="update-info">Укажите информацию для закрытия заявки</label>
                <textarea class="form-control form-modal-info is-invalid" id="update-info" rows="3" name="info"></textarea>
                <small class="invalid-feedback"></small>
                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-success update-submit" type="submit" value="Выполнить"/>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Окно отклонения -->
<div class="modal fade" id="closeHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Отклонить заявку</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="close-form" action="help.closeHelp" method="POST">
            <div class="modal-body form-group">
                <label for="close-info">Укажите причину отклонения</label>
                <textarea class="form-control form-modal-info is-invalid" id="close-info" rows="3" name="info"></textarea>
                <small class="invalid-feedback"></small>

                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-danger close-submit" type="submit" value="Закрыть"/>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

                        <div class="card-footer clearfix">
                            страницы
                        </div>
                    </div>
                </div>
            </div>
            <!--Row-->
            <!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Выход</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите выйти?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отмена</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Выход
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
        </div>
        <!---Container Fluid-->
    </div>
    <!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>copyright &copy; 2022 - сделано в
              <b><a href="/" target="_blank">Администрации</a></b>
            </span>
        </div>
    </div>
</footer>
<!-- Footer -->

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
