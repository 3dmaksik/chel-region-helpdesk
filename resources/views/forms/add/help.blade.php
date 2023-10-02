@extends('layouts.app')
@section('row')
<div class="col-lg-12">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Добавить новую заявку</h6>
        <div class="card-title">
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() }}">
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
        <form id="formValidate" class="form-submit" enctype="multipart/form-data" method="POST"
            action="{{ route(config('constants.help.store')) }}">
            <div class="form-group">
                <label for="select2-category">Выберите категорию</label>
                <select class="select2-single form-control" name="category_id" id="select2-category">
                    @foreach( $items['categories'] as $category)
                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="select2-user">Выберите сотрудника (Также можете выбрать себя)</label>
                <select class="select2-user select2-single form-control" name="user_id" id="select2-user">
                </select>
            </div>
            <div class="form-group">
                <label for="select2-description-long">Введите текст</label>
                <textarea class="form-control" id="select2-description-long" rows="3"
                    name="description_long">{{ old('description_long') }}</textarea>
            </div>
            <div class="form-group">
                <label for="images">Загрузите фото или скриншоты если необходимо</label>
                <div class="custom-file">
                    <label class="custom-file-label" for="customFile">Выберите файлы</label>
                    <input type="file" name="images[]" class="custom-file-input" id="customFile"
                        accept="image/png, image/jpeg" multiple />
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Отменить</a>
        </form>
    </div>
</div>
</div>
@endsection
