@extends('layouts.app')
@section('row')
<div class="col-lg-12 mb-4">
<!-- Simple Tables -->
<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Все Новости</h6>
        @can('create news')
        <a href="{{ route(config('constants.news.create')) }}"> <button type="button"
                class="btn btn-primary mb-1">Добавить новость</button></a>
        @endcan
    </div>
    <div class="col-lg-12 mb-4">
        @forelse ($items['data'] as $item)
        <a href="{{ route(config('constants.news.show'),$item->id) }}">
            <h3 class="text-primary">{{ $item->name }}</h3>
        </a>
        <h6 class="text-primary">{{ $item->description }}</h6>
        <a href="{{ route(config('constants.news.show'),$item->id) }}"> <button type="button"
                class="btn btn-info">Читать далее</button></a>
        @can('edit news')
        <a href="{{ route(config('constants.news.edit'),$item->id) }}"> <button type="button"
                class="btn btn-success">Редактировать</button></a>
        @endcan
        @can('destroy news')
        <a data-toggle="modal" data-target="#removeModal-{{ $item->id}}" href="#"> <button type="button"
                class="btn btn-danger remove">Удалить</button></a>
        <!-- Окно удаления-->
        <div class="modal fade" id="removeModal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Удаление</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="formRemove-{{$item->id}}" class="form-submit"
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
        @endcan
        <div class="mt-2">
        <small class="text-secondary"> {{ $item->created_at}}</small>
        </div>
        <hr/>
        @empty
        <div></div>
        @endforelse
    </div>
</div>
<div class="card-footer d-flex flex-row justify-content-end clearfix">
    {{ $items['data']->links() }}
</div>
</div>
@endsection

