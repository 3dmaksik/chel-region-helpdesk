<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top"> <button id="sidebarToggleTop"
        class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow"> <a class="nav-link dropdown-toggle" href="#" id="searchDropdown"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            @can('all search')
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search" method="GET" action="{{ route('search.all') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-1 small "
                            placeholder="Введите текст для поиска" aria-label="Search" aria-describedby="basic-addon2"
                            style="border-color: #3f51b5;">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
        </li>
        @if(auth()->user()->can('new help') || auth()->user()->can('worker help'))
        <li class="nav-item dropdown no-arrow mx-1"> <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                @can('new help')
                <span id="counter" class="badge badge-danger badge-counter">@if(Cookie::get('newCount') > 0) {{ Cookie::get('newCount') }} @endif</span>
                @endcan
                @can('worker help')
                <span id="counter" class="badge badge-success badge-counter">@if(Cookie::get('nowCount') > 0) {{ Cookie::get('nowCount') }} @endif</span>
                @endcan
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header"> Оповещения </h6>
                @can('new help')
                <a class="dropdown-item d-flex align-items-center" href="{{ route(config('constants.help.new')) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary"> <i class="fas fa-file-alt text-white"></i> </div>
                    </div>
                    <div>
                        <div id="new_count" class="small text-gray-500">Новые заявки</div> <span
                            id="new_count_text">Новые заявки загружаются</span>
                    </div>
                </a>
                @endcan
                @can('worker help')
                <a class="dropdown-item d-flex align-items-center" href="{{ route(config('constants.help.worker')) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-success"> <i class="fas fa-walking text-white"></i> </div>
                    </div>
                    <div>
                        <div id="now_count" class="small text-gray-500">На исполнении</div> <span
                            id="now_count_text">@if(Cookie::get('nowCount') > 0) У вас заявок на исполнении:{{ Cookie::get('nowCount') }} @else Заявки на исполнение загружаются@endif </span>
                    </div>
                </a>
                @endcan
            </div>
        </li>
        @endif
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow"> <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="@if(auth()->user()->avatar !== null)/storage/avatar/{{auth()->user()->avatar}}@else/img/boy.png @endif" style="max-width: 60px">
                <span class="name=profile ml-2 d-none d-lg-inline text-white small">{{ auth()->user()->firstname}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"> <a
                    class="dropdown-item" href="{{ route(config('constants.settings.account')) }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Настройки
                </a>
                <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:void(0);"
                    data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Выход
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- Topbar -->
