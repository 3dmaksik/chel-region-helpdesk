@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Настройки аккаунта</h6>
    </div>
    <div class="card-body">
        <form id="formValidateSettings" class="form-submit" enctype="multipart/form-data" method="POST" action="{{ route(config('constants.settings.updateSettings')) }}">
            @method('PATCH')
            <div class="form-group">
                <div class="text-center">
                    <div id="sent-message-upSettings" style="display: none"> </div>
                </div>
                <div class="form-group">
                    <label for="img-profile">Текущая аватарка</label>
                    <div class="form-group">
                        <img class="img-profile rounded-circle"
                            src="@if($works['avatar']==null)/img/boy.png @else{{asset('/storage/avatar/'.$works['avatar']) }} @endif"
                            style="max-width: 60px">
                    </div>
                </div>
                <div class="form-group">
                    <label for="select2-images">Загрузить аватарку, если необходимо (не более 60x60px)</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="customFile">Выберите файлы</label>
                        <input type="file" name="avatar" class="custom-file-input" id="customFile"
                            accept="image/png, image/jpeg" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <figure>
                            <figcaption>Текущее оповещение</figcaption>
                            <audio controls
                                src="@if($works['sound_notify']==null)/sound/sound.ogg @else{{ asset('/storage/sound/'.$works['sound_notify']) }} @endif">
                            </audio>
                        </figure>
                    </div>
                    <label for="sound_notify">Загрузить звук оповещения, если необходимо (формат ogg)</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="customFile">Выберите файлы</label>
                        <input type="file" name="sound_notify" class="custom-file-input" id="customFile2"
                            accept="audio/ogg" />
                    </div>
                </div>
                <input class="btn btn-primary" type="submit" value="Отправить" />
                <a class="btn btn-secondary" href="{{ url()->previous() }}">Отменить</a>
        </form>
    </div>
</div>
@endsection