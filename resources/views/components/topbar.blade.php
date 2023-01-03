<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top"> <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown no-arrow"> <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </a>
			<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
				<form class="navbar-search" method="POST" action="{{ route('search.all') }}">
                    @csrf
					<div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-1 small " placeholder="Введите текст для поиска" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
						<div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button> </div>
					</div>
				</form>
			</div>
		</li>
		<li class="nav-item dropdown no-arrow mx-1"> <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span id="counter" class="badge badge-danger badge-counter">1</span>
        </a>
			<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
				<h6 class="dropdown-header"> Оповещения </h6>
				<a class="dropdown-item d-flex align-items-center" href="#">
					<div class="mr-3">
						<div class="icon-circle bg-primary"> <i class="fas fa-file-alt text-white"></i> </div>
					</div>
					<div>
						<div id="new_count" class="small text-gray-500">Новые заявки</div> У вас новых заявок: 1 </div>
				</a>
				<a class="dropdown-item d-flex align-items-center" href="/panel/search/status/2">
					<div class="mr-3">
						<div class="icon-circle bg-success"> <i class="fas fa-walking text-white"></i> </div>
					</div>
					<div>
						<div id="now_count" class="small text-gray-500">На исполнении</div> У вас заявок на исполнении: 1 </div>
				</a>
			</div>
		</li>
		<li class="nav-item dropdown no-arrow mx-1"> <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-tasks fa-fw"></i>
      <span class="badge badge-success badge-counter">3</span>
    </a>
			<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
				<h6 class="dropdown-header"> Задачи</h6>
				<a class="dropdown-item align-items-center" href="#">
					<div class="mb-3">
						<div class="small text-gray-500">Первая
							<div class="small float-right"><b>50%</b></div>
						</div>
						<div class="progress" style="height: 12px;">
							<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</a>
				<a class="dropdown-item align-items-center" href="#">
					<div class="mb-3">
						<div class="small text-gray-500">Вторая
							<div class="small float-right"><b>30%</b></div>
						</div>
						<div class="progress" style="height: 12px;">
							<div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</a>
				<a class="dropdown-item align-items-center" href="#">
					<div class="mb-3">
						<div class="small text-gray-500">Третья
							<div class="small float-right"><b>75%</b></div>
						</div>
						<div class="progress" style="height: 12px;">
							<div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</a> <a class="dropdown-item text-center small text-gray-500" href="#">Посмотреть все задачи</a> </div>
		</li>
		<div class="topbar-divider d-none d-sm-block"></div>
		<li class="nav-item dropdown no-arrow"> <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="img-profile rounded-circle" src="@if(auth()->user()->avatar==null)/img/boy.png @else{{ auth()->user()->avatar}} @endif" style="max-width: 60px">
            <span class="ml-2 d-none d-lg-inline text-white small">{{ auth()->user()->firstname}}</span>
        </a>
			<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"> <a class="dropdown-item" href="/panel/settings/edit/">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
               Настройки
            </a>
				<div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Выход
            </a> </div>
		</li>
	</ul>
</nav>
<!-- Topbar -->
