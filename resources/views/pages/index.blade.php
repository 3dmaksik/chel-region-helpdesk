<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('settings.title') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="_token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="/img/logo/logo.png" rel="icon">

    <!-- Template Main CSS File -->
    <link href="{{ mix('css/estartup.min.css') }}" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <div id="logo">
                <h1><a href="#"><span>Журнал</span>Заявок</a></h1>
            </div>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="" data-toggle="modal" data-target="#login">Войти</a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="hero-container" data-aos="fade-in">
            <h1>Добро пожаловать в журнал заявок</h1>
            @if (config('settings.startForm') == true)
            <h2>Войдите по логину и паролю, чтобы оставить заявку, либо нажмите кнопку ниже, если ваш компьютер
                недоступен</h2>
            <img src="/img/hero-img.png" alt="Hero Imgs" data-aos="zoom-out" data-aos-delay="100">
            <a href="#get-form" class="btn-get-started scrollto">Оставить заявку</a>
            @else
            <h2>Войдите по логину и паролю, чтобы оставить заявку</h2>
            <img src="/img/hero-img.png" alt="Hero Imgs" data-aos="zoom-out" data-aos-delay="100">
            @endif
        </div>
    </section><!-- End Hero Section -->
    <main id="main">
        <!-- ======= Get Form Section ======= -->
        @if (config('settings.startForm') == true)
        <section id="get-form" class="padd-section">
            <div class="container" data-aos="fade-up">
                <div class="section-title text-center">
                    <h2>Новая Заявка</h2>
                    <p class="separator">Внимательно заполните все поля и правильно выберите ФИО во избежание ошибок.
                    </p>
                </div>
                <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-8 col-md-6">
                        <div class="form">
                            <form name="form" id="formValidate" enctype="multipart/form-data" method="POST"
                                action="{{ route('index.store') }}" role="form" class="php-email-form">
                                @csrf
                                <div class="form-group">
                                    <label for="select2-category">Выберите категорию</label>
                                    <select class="select2-single form-control" data-aos-delay="100" name="category_id"
                                        id="select2-category">
                                        @foreach( $items['category'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="select2-user">Выберите сотрудника</label>
                                    <select class="select2-single form-control" data-val="true" name="user_id"
                                        id="select2-user">
                                        @foreach( $items['user'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->lastname }} {{ $item->firstname }} {{
                                            $item->patronymic }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="select2-description-long">Введите текст</label>
                                    <textarea class="form-control" id="select2-description-long" rows="3"
                                        name="description_long"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="select2-images">Загрузите фото или скриншоты если необходимо</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="customFile">Выберите файлы</label>
                                        <input type="file" name="images[]" class="custom-file-input" id="customFile"
                                            accept="image/png, image/jpeg" multiple />
                                    </div>
                                </div>
                                <div class="my-3 text-center">
                                    <div id="error-message" style="display: none"></div>
                                    <div id="sent-message" style="display: none"> </div>
                                </div>
                                <div class="text-center"><input class="btn-get-started" type="submit"
                                        value="Отправить" /></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
    </main>
    <!-- ======= Footer ======= -->
    <footer class="footer">
        <div class="copyrights">
            <div class="container">
                <div class="credits">
                    <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=eStartup
        -->
                    Основа дизайна- BootstrapMade
                </div>
                <p>copyright &copy; 2022 - сделано в
                    <b><a href="/" target="_blank">Администрации</a></b>
                </p>
            </div>
        </div>

    </footer><!-- End  Footer -->

    <a href="#header" class="back-to-top scrollto d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вход</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div id="errors-list" style="display: none"></div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="description" required
                            autocomplete="name" placeholder="Введите логин" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" required autocomplete="password"
                            placeholder="Введите пароль">
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                            <input class="custom-control-input" type="checkbox" name="remember" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Запомнить меня</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 mx-auto">
                        <button type="submit" class="btn btn-primary btn-block text-center">
                            Войти
                        </button>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>
    <!-- Template Main JS File -->
    <script src="{{ mix('/js/estartup.min.js') }}"></script>

</body>

</html>
