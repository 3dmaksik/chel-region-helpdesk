<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion d-print-none" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route(config('constants.news.index')) }}">
        <div class="sidebar-brand-icon"> <img src="/img/logo/logo2.png"> </div>
        <div class="sidebar-brand-text mx-3">Журнал заявок</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li id="newsSidebar">
    <li class="nav-item {{ request()->segment(1) == 'news' ? 'active':'' }}"> <a class="nav-link"
            href="{{ route(config('constants.news.index')) }}">
            <i class="fas fa-solid fa-book"></i>
            <span>Новости</span>
        </a> </li>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading"> Журнал </div>
    @can('work directory list')
    <li id="workSidebar" class="nav-item ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#WorkForm" aria-expanded="false"
            aria-controls="WorkForm">
            <i class="fas fa-fw fa-table-columns"></i>
            <span>Рабочие заявки</span>
        </a>
        <div id="WorkForm"
            class="collapse {{ request()->segment(1) == 'admin' && request()->segment(2) == 'helps' || request()->segment(3) =='show' && request()->segment(1) == 'admin' ? 'show':'' }}"
            aria-labelledby="headingForm" data-parent="#workSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Рабочие заявки</h6>
                @can('all help')
                <a class="collapse-item  {{ request()->segment(1) == 'admin' && request()->segment(2) == 'helps' && request()->segment(3) == 'all' ||  url()->previous() == route(config('constants.help.index')) && request()->segment(3) =='show' && request()->segment(1) == 'admin' ? 'active':'' }}"
                    href="{{ route(config('constants.help.index')) }}">Все</a>
                @endcan
                @can('new help')
                <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'helps' && request()->segment(3) == 'new' ||  url()->previous() == route(config('constants.help.new')) && request()->segment(3) =='show' && request()->segment(1) == 'admin' ? 'active':'' }}"
                    href="{{ route(config('constants.help.new')) }}">Новые</a>
                @endcan
                @can('worker help')
                <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'helps' && request()->segment(3) == 'worker' ||  url()->previous() == route(config('constants.home.worker')) || url()->previous() == route(config('constants.help.worker')) && request()->segment(3) =='show' && request()->segment(1) == 'admin' ? 'active':'' }}"
                    href="{{ route(config('constants.help.worker')) }}">В работе</a>
                @endcan
                @can('completed help')
                <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'helps' && request()->segment(3) == 'completed' ||  url()->previous() == route(config('constants.home.completed')) ||  url()->previous() == route(config('constants.help.completed')) && request()->segment(3) =='show' && request()->segment(1) == 'admin' ? 'active':'' }}"
                    href="{{ route(config('constants.help.completed')) }}">Выполненные</a>
                @endcan
                @can('dismiss help')
                <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'helps' && request()->segment(3) == 'dismiss' ||  url()->previous() == route(config('constants.home.dismiss')) ||  url()->previous() == route(config('constants.help.dismiss')) && request()->segment(3) =='show' && request()->segment(1) == 'admin' ? 'active':'' }}"
                    href="{{ route(config('constants.help.dismiss')) }}">Отклонённые</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    @can('home directory list')
    <li id="UserSidebar" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#UserForm" aria-expanded="false"
            aria-controls="UserForm">
            <i class="fas fa-regular fa-house"></i>
            <span>Мои заявки</span>
        </a>
        <div id="UserForm"
            class="collapse {{ request()->segment(1) == 'home' && request()->segment(2) == 'helps' || request()->segment(3) == 'show' && request()->segment(1) == 'home' ? 'show':'' }}"
            aria-labelledby="headingForm" data-parent="#UserSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Мои заявки</h6>
                <a class="collapse-item {{ request()->segment(1) == 'home' && request()->segment(2) == 'helps' && request()->segment(3) == 'worker' ||  url()->previous() == route(config('constants.home.worker')) && request()->segment(3) =='show' && request()->segment(1) == 'home' ? 'active':'' }}"
                    href="{{ route(config('constants.home.worker')) }}">В работе</a>
                <a class="collapse-item {{ request()->segment(1) == 'home' && request()->segment(2) == 'helps' && request()->segment(3) == 'completed' ||  url()->previous() == route(config('constants.home.completed')) && request()->segment(3) =='show' && request()->segment(1) == 'home' ? 'active':'' }}"
                    href="{{ route(config('constants.home.completed')) }}">Выполненные</a>
                <a class="collapse-item {{ request()->segment(1) == 'home' && request()->segment(2) == 'helps' && request()->segment(3) == 'dismiss' ||  url()->previous() == route(config('constants.home.dismiss')) && request()->segment(3) =='show' && request()->segment(1) == 'home' ? 'active':'' }}"
                    href="{{ route(config('constants.home.dismiss')) }}">Отклонённые</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    @endcan
    @can('all directory list')
    <div class="sidebar-heading"> Списки </div>
    @can('view category')
    <li class="nav-item {{ request()->segment(2) == 'category' ? 'active':'' }}"> <a
            class="nav-link" href="{{ route(config('constants.category.index')) }}">
            <i class="fas fa-fw fa-angle-double-up"></i>
            <span>Категории</span>
        </a>
    </li>
    @endcan
    @can('view status')
    <li class="nav-item {{ request()->segment(2) == 'status' ? 'active':'' }}"> <a
            class="nav-link" href="{{ route(config('constants.status.index')) }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Статусы</span>
        </a>
    </li>
    @endcan
    @can('view cabinet')
    <li class="nav-item {{ request()->segment(2) == 'cabinet' ? 'active':'' }}"> <a
            class="nav-link" href="{{ route(config('constants.cabinet.index')) }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Кабинеты</span>
        </a>
    </li>
    @endcan
    @can('view priority')
    <li class="nav-item {{ request()->segment(2) == 'priority' ? 'active':'' }}"> <a
            class="nav-link" href="{{ route(config('constants.priority.index')) }}">
            <i class="fas fa-fw fa-signal"></i>
            <span>Приоритеты</span>
        </a>
    </li>
    @endcan
    @can('view user')
    <li class="nav-item {{ request()->segment(2) == 'users' ? 'active':'' }}"> <a
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
                class="collapse {{ request()->segment(1) == 'settings' ? 'show':'' }}"
                aria-labelledby="headingForm" data-parent="#settings" style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item  {{ request()->segment(2) == 'account' ? 'active':'' }}"
                        href="{{ route(config('constants.settings.account')) }}">Настройки аккаунта
                    </a>
                    <a class="collapse-item  {{ request()->segment(2) == 'password' ? 'active':'' }}"
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
