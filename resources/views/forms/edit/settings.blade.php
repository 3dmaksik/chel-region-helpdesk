@extends('layouts.app')
@section('components.grid')
col-lg-6
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Настройки пароля</h6>
    </div>
    <div class="card-body">
      <form id="formValidatePassword" method="POST" action="{{ route(config('constants.settings.updatePassword')) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="">Введите существующий пароль</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current_password" name="current_password">
            @error('current_password')
            <small class="invalid-feedback">Текущий пароль неверен</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Введите новый пароль</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" name="password">
            @error('password')
            <small class="invalid-feedback">Текущий пароль похож на старый</small>
            @enderror
        </div>
        <div class="form-group">
            @if($errors->any())
            <small style="color: #fc544b">Неверный существующий пароль</small>
            @endif
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
      </form>
    </div>
  </div>
@endsection
@section('components.grid.right')
col-lg-6
@endsection
@section('row.right')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Настройки аккаунта</h6>
    </div>
    <div class="card-body">
      <form id="formValidateSettings" enctype="multipart/form-data" method="POST" action="{{ route(config('constants.settings.updateSettings')) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="img-profile">Текущая аватарка</label>
            <div class="form-group">
                <img class="img-profile rounded-circle" src="@if($works['avatar']==null)/img/boy.png @else{{ url('storage/'.$works['avatar']['url']) }} @endif" style="max-width: 60px">
            </div>
        </div>
        <div class="form-group">
            <label for="select2-images">Загрузить аватарку, если необходимо (не более 60x60px)</label>
            <div class="custom-file">
                <label class="custom-file-label" for="customFile">Выберите файлы</label>
                <input type="file" name="avatar" class="custom-file-input" id="customFile" accept="image/png, image/jpeg" />
            </div>
            @error('avatar')
            <small class="invalid-feedback">Неверное расширение или превышен размер фото</small>
            @enderror
        </div>
        <div class="form-group">
            <div class="form-group">
                <figure>
                    <figcaption>Текущее оповещение</figcaption>
                    <audio
                        controls
                        src="@if($works['sound_notify']==null)/sound/sound.ogg @else{{ url('storage/'.$works['sound_notify']['url']) }} @endif">
                    </audio>
                </figure>
            </div>
            <label for="sound_notify">Загрузить звук оповещения, если необходимо (формат ogg)</label>
            <div class="custom-file">
                <label class="custom-file-label" for="customFile">Выберите файлы</label>
                <input type="file" name="sound_notify" class="custom-file-input" id="customFile2" accept="audio/ogg" />
            </div>
            @error('sound_notify')
            <small class="invalid-feedback">Неверное расширение или превышен размер фото</small>
            @enderror
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
      </form>
    </div>
</div>
@endsection
