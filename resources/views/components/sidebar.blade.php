<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion d-print-none" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route(config('constants.help.index')) }}">
		<div class="sidebar-brand-icon"> <img src="/img/logo/logo2.png"> </div>
		<div class="sidebar-brand-text mx-3">Главные заявки</div>
	</a>
	<hr class="sidebar-divider my-0">
    @hasanyrole('superAdmin|admin|manager')
    <li id="workSidebar" class="nav-item ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#WorkForm" aria-expanded="false" aria-controls="WorkForm">
          <i class="fas fa-fw fa-table-columns"></i>
          <span>Рабочие заявки</span>
        </a>
        <div id="WorkForm" class="collapse {{ request()->segment(1) == 'admin' || request()->segment(1) == 'mod' && request()->segment(2) == 'helps' ? 'show':'' }}" aria-labelledby="headingForm" data-parent="#workSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Рабочие заявки</h6>
            @hasrole('superAdmin')
            <a class="collapse-item  {{ request()->segment(1) == 'admin' && request()->segment(3) == 'all' ? 'active':'' }}" href="{{ route(config('constants.help.index')) }}">Все</a>
            @endhasanyrole
            @hasanyrole('superAdmin|admin')
            <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(3) == 'new' ? 'active':'' }}" href="{{ route(config('constants.help.new')) }}">Новые</a>
            <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(3) == 'worker'? 'active':'' }}" href="{{ route(config('constants.help.worker')) }}">В работе</a>
            <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(3) == 'completed' ? 'active':'' }}" href="{{ route(config('constants.help.completed')) }}">Выполненные</a>
            <a class="collapse-item {{ request()->segment(1) == 'admin' && request()->segment(3) == 'dismiss' ? 'active':'' }}" href="{{ route(config('constants.help.dismiss')) }}">Отклонённые</a>
            @endhasanyrole
            @hasrole('manager')
            <a class="collapse-item {{ request()->segment(1) == 'mod' && request()->segment(3) == 'worker' ? 'active':'' }}" href="{{ route(config('constants.mod.worker')) }}">В работе</a>
            <a class="collapse-item {{ request()->segment(1) == 'mod' && request()->segment(3) == 'completed' ? 'active':'' }}" href="{{ route(config('constants.mod.completed')) }}">Выполненные</a>
            @endhasanyrole
        </div>
        </div>
      </li>
      @endhasanyrole
      <li id="UserSidebar" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#UserForm" aria-expanded="false" aria-controls="UserForm">
          <i class="fas fa-regular fa-house"></i>
          <span>Мои заявки</span>
        </a>
        <div id="UserForm" class="collapse {{ request()->segment(1) == 'user' && request()->segment(2) == 'helps' ? 'show':'' }}" aria-labelledby="headingForm" data-parent="#UserSidebar" style="">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Мои заявки</h6>
            <a class="collapse-item {{ request()->segment(1) == 'user' && request()->segment(3) == 'worker' ? 'active':'' }}" href="{{ route(config('constants.user.worker')) }}">В работе</a>
            <a class="collapse-item {{ request()->segment(1) == 'user' && request()->segment(3) == 'completed' ? 'active':'' }}" href="{{ route(config('constants.user.completed')) }}">Выполненные</a>
            <a class="collapse-item {{ request()->segment(1) == 'user' && request()->segment(3) == 'dismiss' ? 'active':'' }}" href="{{ route(config('constants.user.dismiss')) }}">Отклонённые</a>
        </div>
        </div>
      </li>
	<hr class="sidebar-divider">
    @hasrole('superAdmin')
	<div class="sidebar-heading"> Списки </div>
	<li class="nav-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'category' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.category.index')) }}">
            <i class="fas fa-fw fa-angle-double-up"></i>
            <span>Категории</span>
        </a> </li>
	<li class="nav-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'status' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.status.index')) }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Статусы</span>
        </a> </li>
	<li class="nav-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'cabinet' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.cabinet.index')) }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Кабинеты</span>
        </a> </li>
   <li class="nav-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'priority' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.priority.index')) }}">
            <i class="fas fa-fw fa-signal"></i>
            <span>Приоритеты</span>
    </a> </li>
	<li class="nav-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'work' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.work.index')) }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Сотрудники</span>
        </a> </li>
        <li class="nav-item {{ request()->segment(1) == 'admin' && request()->segment(2) == 'users' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.users.index')) }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Пользователи</span>
    </a> </li>
    <hr class="sidebar-divider">
    @endhasrole
	<div class="sidebar-heading"> Дополнительное </div>
	<li class="nav-item active"> <a class="nav-link" href="/panel/stat">
            <i class="fas fa-fw fa-star"></i>
            <span>Статистика</span>
        </a> </li>
        <li class="nav-item {{ request()->segment(1) == 'settings' ? 'active':'' }}"> <a class="nav-link" href="{{ route(config('constants.settings.edit')) }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Настройки</span>
        </a> </li>
	<hr class="sidebar-divider">
	<div class="version" id="version-ruangadmin"></div>
	<div class="version">Страница обновлена в: 1 мин.</div>
</ul>
<!-- Sidebar -->
