<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion d-print-none" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route(config('constants.help.index')) }}">
		<div class="sidebar-brand-icon"> <img src="/img/logo/logo2.png"> </div>
		<div class="sidebar-brand-text mx-3">Главные заявки</div>
	</a>
	<hr class="sidebar-divider my-0">
	<li class="nav-item {{ (request()->segment(2) == 'help') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.help.index')) }}">
            <i class="fas fa-fw fa-table-columns"></i>
            <span>Панель</span></a> </li>
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Списки </div>
	<li class="nav-item {{ (request()->segment(2) == 'category') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.category.index')) }}">
            <i class="fas fa-fw fa-angle-double-up"></i>
            <span>Категории</span>
        </a> </li>
	<li class="nav-item {{ (request()->segment(2) == 'status') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.status.index')) }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Статусы</span>
        </a> </li>
	<li class="nav-item {{ (request()->segment(2) == 'cabinet') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.cabinet.index')) }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Кабинеты</span>
        </a> </li>
   <li class="nav-item {{ (request()->segment(2) == 'priority') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.priority.index')) }}">
            <i class="fas fa-fw fa-signal"></i>
            <span>Приоритеты</span>
    </a> </li>
	<li class="nav-item {{ (request()->segment(2) == 'work') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.work.index')) }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Сотрудники</span>
        </a> </li>
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Дополнительное </div>
	<li class="nav-item active"> <a class="nav-link" href="/panel/stat">
            <i class="fas fa-fw fa-star"></i>
            <span>Статистика</span>
        </a> </li>
        <li class="nav-item {{ (request()->segment(2) == 'settings') ? 'active' : '' }}"> <a class="nav-link" href="{{ route(config('constants.settings.edit')) }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Настройки</span>
        </a> </li>
	<hr class="sidebar-divider">
	<div class="version" id="version-ruangadmin"></div>
	<div class="version">Страница обновлена в: 1 мин.</div>
</ul>
<!-- Sidebar -->
