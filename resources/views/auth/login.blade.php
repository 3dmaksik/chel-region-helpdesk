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
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Введите логин">
                        <span class="invalid-feedback" role="alert">
                         <strong>Неверный логин или неправильно заполнен</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Введите пароль">
                       <span class="invalid-feedback" role="alert">
                       <strong>Неверный пароль</strong>
                       </span>
                    </div>
                    <div class="form-group">
                        @if(Session::has('error'))
                        <div class="alert alert-danger">
                         {{ Session::get('error')}}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input class="custom-control-input" type="checkbox" name="remember" id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customCheck">Запомнить меня</label>
                      </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            Вход
                        </button>
                    </div>
                    <hr>
                  </form>
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
