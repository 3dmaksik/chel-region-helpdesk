@extends('layouts.app')
@section('row')
<div class="col-lg-12 mb-4">
<!-- Simple Tables -->
<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Все категории</h6>
        <a href="{{ route(config('constants.category.create')) }}"> <button type="button"
                class="btn btn-primary mb-1">Новая категория</button></a>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th style="width: 90%">Категория</th>
                    <th class="d-print-none"></th>
                </tr>
            </thead>
            <tbody id="table-dynamic">
                @forelse ($items['data'] as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="d-print-none">
                        <div class="block">
                            <a href="{{ route(config('constants.category.edit'),$item->id) }}"
                                class="btn btn-success btn-sm hover">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="hidden">Редактировать категорию</span> <!-- скрытый элемент -->
                        </div>
                        <div class="block">
                            <a data-toggle="modal" data-target="#removeModal-{{ $item->id}}" href="#"
                                class="btn btn-danger btn-sm hover remove"><i class="fas fa-trash"></i></a>
                            <span class="hidden">Удалить категорию</span> <!-- скрытый элемент -->
                        </div>
                        <!-- Окно удаления-->
                        <div class="modal fade" id="removeModal-{{$item->id}}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Удаление</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form id="formRemove-{{$item->id}}" class="form-submit"
                                        action="{{ route(config('constants.category.destroy'),$item->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <p class="text-center">Вы действительно хотите удалить запись?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer form-group">
                                            <button type="button" class="btn btn-outline-primary"
                                                data-dismiss="modal">Отменить</button>
                                            <input class="btn btn-danger remove-submit" type="submit" value="Да" />
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex flex-row justify-content-end clearfix">
    {{ $items['data']->links() }}
</div>
</div>
@endsection
