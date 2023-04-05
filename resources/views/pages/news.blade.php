@extends('layouts.app')
@section('components.grid')
col-lg-12 mb-4
@endsection
@section('row')
<!-- Simple Tables -->
<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Все Новости</h6>
        @hasanyrole('superAdmin|admin')
        <a href="{{ route(config('constants.news.create')) }}"> <button type="button"
                class="btn btn-primary mb-1">Добавить новость</button></a>
        @endhasanyrole
    </div>
    <div class="col-lg-12 mb-4">
        @forelse ($items['data'] as $item)
        <a href="{{ route(config('constants.news.show'),$item->id) }}">
            <h3 class="text-primary">{{ $item->name }}</h3>
        </a>
        <h6 class="text-primary">{{ $item->description }}</h6>
        <br>
        <h6>Дата публикации: {{ date( 'd.m.Y H:i', strtotime($item->created_at))}}</h6>
        <a href="{{ route(config('constants.news.show'),$item->id) }}"> <button type="button"
                class="btn btn-info">Читать далее</button></a>
        @hasanyrole('superAdmin|admin')
        <a href="{{ route(config('constants.news.edit'),$item->id) }}"> <button type="button"
                class="btn btn-success">Редактировать новость</button></a>
        <a data-toggle="modal" data-target="#removeModal-{{ $item->id}}" href="#"> <button type="button"
                class="btn btn-danger remove">Удалить новость</button></a>
        <!-- Окно удаления-->
        <div class="modal fade" id="removeModal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Удаление</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="formRemove-{{$item->id}}" class="remove-form"
                        action="{{ route(config('constants.news.destroy'),$item->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <p class="text-center">Вы действительно хотите удалить запись?</p>
                            </div>
                        </div>
                        <div class="modal-footer form-group">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                            <input class="btn btn-danger remove-submit" type="submit" value="Да" />
                        </div>
                </div>
                </form>
            </div>
        </div>
        @endhasanyrole
        <hr>
        @empty
        <div></div>
        @endforelse
    </div>
</div>

@endsection
@section('paginate')
<div class="card-footer clearfix">
    {{ $items['data']->links() }}
</div>
@endsection
