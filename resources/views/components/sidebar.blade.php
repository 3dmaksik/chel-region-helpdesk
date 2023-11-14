<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion d-print-none" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route(config('constants.news.index')) }}">
        <div class="sidebar-brand-icon"> <img src="/img/logo/logo2.png"> </div>
        <div class="sidebar-brand-text mx-3">Журнал заявок</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li id="newsSidebar">
    <li class="nav-item {{ request()->routeIs('news.index') ? 'active' : '' }}"> <a class="nav-link"
            href="{{ route(config('constants.news.index')) }}">
            <i class="fas fa-solid fa-book"></i>
            <span>Новости</span>
        </a> </li>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading"> Журнал </div>
    @can('work directory list')
    <li id="workSidebar" class="nav-item ">
        <a class="nav-link {{ request()->is('admin/helps/*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#WorkForm" aria-expanded="false"
            aria-controls="WorkForm">
            <i class="fas fa-fw fa-table-columns"></i>
            <span>Рабочие заявки</span>
        </a>
        <div id="WorkForm"
            class="collapse {{ request()->is('admin/helps/*') ? 'show' : '' }}"
            aria-labelledby="headingForm" data-parent="#workSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Рабочие заявки</h6>
                @can('all help')
                <a class="collapse-item  {{ request()->routeIs('help.index') ? 'active' : '' }}"
                    href="{{ route(config('constants.help.index')) }}">Все</a>
                @endcan
                @can('new help')
                <a class="collapse-item {{ request()->routeIs('help.new') ? 'active' : '' }}"
                    href="{{ route(config('constants.help.new')) }}">Новые</a>
                @endcan
                @can('worker help')
                <a class="collapse-item {{ request()->routeIs('help.worker') ? 'active' : '' }}"
                    href="{{ route(config('constants.help.worker')) }}">В работе</a>
                @endcan
                @can('completed help')
                <a class="collapse-item {{ request()->routeIs('help.completed') ? 'active' : '' }}"
                    href="{{ route(config('constants.help.completed')) }}">Выполненные</a>
                @endcan
                @can('dismiss help')
                <a class="collapse-item {{ request()->routeIs('help.dismiss') ? 'active' : '' }}"
                    href="{{ route(config('constants.help.dismiss')) }}">Отклонённые</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    @can('home directory list')
    <li id="UserSidebar" class="nav-item">
        <a class="nav-link {{ request()->is('home/helps/*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#UserForm" aria-expanded="false"
            aria-controls="UserForm">
            <i class="fas fa-regular fa-house"></i>
            <span>Мои заявки</span>
        </a>
        <div id="UserForm"
            class="collapse {{ request()->is('home/helps/*') ? 'show' : '' }}"
            aria-labelledby="headingForm" data-parent="#UserSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Мои заявки</h6>
                <a class="collapse-item {{ request()->routeIs('home.worker') ? 'active' : '' }}"
                    href="{{ route(config('constants.home.worker')) }}">В работе</a>
                <a class="collapse-item {{ request()->routeIs('home.completed') ? 'active' : '' }}"
                    href="{{ route(config('constants.home.completed')) }}">Выполненные</a>
                <a class="collapse-item {{ request()->routeIs('home.dismiss') ? 'active' : '' }}"
                    href="{{ route(config('constants.home.dismiss')) }}">Отклонённые</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    @endcan
    @can('all directory list')
    <div class="sidebar-heading"> Списки </div>
    @can('view category')
    <li class="nav-item {{ request()->routeIs('catergory.index') ? 'active' : '' }}}"> <a
            class="nav-link" href="{{ route(config('constants.category.index')) }}">
            <i class="fas fa-fw fa-angle-double-up"></i>
            <span>Категории</span>
        </a>
    </li>
    @endcan
    @can('view status')
    <li class="nav-item {{ request()->routeIs('status.index') ? 'active' : '' }}"> <a
            class="nav-link" href="{{ route(config('constants.status.index')) }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Статусы</span>
        </a>
    </li>
    @endcan
    @can('view cabinet')
    <li class="nav-item {{ request()->routeIs('cabinet.index') ? 'active' : '' }}"> <a
            class="nav-link" href="{{ route(config('constants.cabinet.index')) }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Кабинеты</span>
        </a>
    </li>
    @endcan
    @can('view priority')
    <li class="nav-item {{ request()->routeIs('priority.index') ? 'active' : '' }}"> <a
            class="nav-link" href="{{ route(config('constants.priority.index')) }}">
            <i class="fas fa-fw fa-signal"></i>
            <span>Приоритеты</span>
        </a>
    </li>
    @endcan
    @can('view user')
    <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}"> <a
            class="nav-link" href="{{ route(config('constants.users.index')) }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Пользователи</span>
        </a>
    </li>
    @endcan
    <hr class="sidebar-divider">
    @endcan
    @can('edit settings')
    <div class="sidebar-heading"> Дополнительное </div>
        <li id="settings" class="nav-item ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#SettingsForm" aria-expanded="false"
                aria-controls="SettingsForm">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Настройки</span>
            </a>
            <div id="SettingsForm"
                class="collapse {{ request()->is('settings*') ? 'show' : '' }}"
                aria-labelledby="headingForm" data-parent="#settings" style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item  {{ request()->is('settings/account') ? 'active' : '' }}"
                        href="{{ route(config('constants.settings.account')) }}">Настройки аккаунта
                    </a>
                    <a class="collapse-item  {{ request()->is('settings/password') ? 'active' : '' }}"
                        href="{{ route(config('constants.settings.password')) }}">Изменение пароля
                    </a>
                </div>
            </div>
        </li>
    @endcan
    @can('view stats')
    <li class="nav-item {{ request()->segment(1) == 'stats' ? 'active':'' }}"> <a class="nav-link"
            href="{{ route('stats') }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Статистика</span>
        </a>
    </li>
    @endcan
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
    <div class="version">Страница открыта в {{ $now->format('H:i')}}</div>
</ul>
<!-- Sidebar -->
