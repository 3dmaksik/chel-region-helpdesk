@extends('layouts.app')
@section('components.grid')
col-lg-12
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Добавить новую заявку</h6>
        <div class="card-title">
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ route(config('constants.help.worker')) }}">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a> <span class="hidden">Назад</span>
                <!-- скрытый элемент -->
            </div>
            <div class="block d-print-none">
                <a style="color: #757575;" class="hover" href="javascript:(print());">
                    <i class="fas fa-print fa-lg"></i>
                </a> <span class="hidden">Печать</span>
                <!-- скрытый элемент -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="formValidate" enctype="multipart/form-data" method="POST"
            action="{{ route(config('constants.home.store')) }}">
            <div class="form-group">
                <div class="text-center">
                    <div id="sent-message-send" style="display: none"> </div>
                </div>
                <label for="select2-category">Выберите категорию</label>
                <select class="select2-single form-control" name="category_id" id="select2-category">
                    @foreach( $items['category'] as $item)
                    <option @if (old('category_id')=="$item->id" ) selected @endif value="{{ $item->id }}">{{
                        $item->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="select2-description-long">Введите текст</label>
                <textarea class="form-control @error('description_long') is-invalid @enderror"
                    id="select2-description-long" rows="3"
                    name="description_long">{{ old('description_long') }}</textarea>
                @error('description_long')
                <small class="invalid-feedback">Текст не введён</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="select2-images">Загрузите фото или скриншоты если необходимо</label>
                <div class="custom-file">
                    <label class="custom-file-label" for="customFile">Выберите файлы</label>
                    <input type="file" name="images[]" class="custom-file-input" id="customFile"
                        accept="image/png, image/jpeg" multiple />
                </div>
                @error('images')
                <small class="invalid-feedback">Неверное расширение или превышен размер фото</small>
                @enderror
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            <a class="btn btn-secondary" href="{{ route(config('constants.help.index')) }}">Отменить</a>
        </form>
    </div>
</div>
@endsection
