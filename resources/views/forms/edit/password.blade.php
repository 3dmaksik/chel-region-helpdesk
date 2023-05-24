@extends('layouts.app')
@section('row')
<div class="col-lg-4">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Изменить пароль</h6>
    </div>
    <div class="card-body">
        <form id="formValidatePassword" class="form-submit" method="POST" action="{{ route(config('constants.settings.updatePassword')) }}">
            @method('PATCH')
            <div class="form-group">
                <label for="">Введите существующий пароль</label>
                <input type="password" class="form-control" name="current_password" required autocomplete="current_password" name="current_password">
            </div>
            <div class="form-group">
                <label for="">Введите новый пароль</label>
                <input type="password" class="form-control" name="password" required autocomplete="password" name="password">
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
        </form>
    </div>
</div>
</div>
@endsection
