<!DOCTYPE html>
<html lang="ru">
@include('components.head')

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Вход</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="description" required autocomplete="name"
                                                placeholder="Введите логин" autocomplete="off">
                                            @error('name')
                                            <small class="invalid-feedback">Пароль и логин не совпадает</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" required
                                                autocomplete="password" placeholder="Введите пароль">
                                        </div>
                                        <div class="form-group">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small"
                                                style="line-height: 1.5rem;">
                                                <input class="custom-control-input" type="checkbox" name="remember"
                                                    id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck">Запомнить
                                                    меня</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Вход
                                            </button>
                                        </div>
                                        <hr>
                                    </form>
                                    <div class="text-center version" id="version-ruangadmin"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="{{ mix('/js/app.js') }}"></script>

</html>
