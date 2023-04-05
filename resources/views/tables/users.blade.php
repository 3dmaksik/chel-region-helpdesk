@extends('layouts.app')
@section('components.grid')
col-lg-12 mb-4
@endsection
@section('row')
<!-- Simple Tables -->
<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Все пользователи</h6>
        <a href="{{ route(config('constants.users.create')) }}"> <button type="button"
                class="btn btn-primary mb-1">Новый пользователь </button></a>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th style="width: 10%">Логин</th>
                    <th style="width: 15%">Фамилия</th>
                    <th style="width: 15%">Имя</th>
                    <th style="width: 15%">Отчество</th>
                    <th style="width: 30%">Роль</th>
                    <th class="d-print-none"></th>
                </tr>
            </thead>
            <tbody id="table-dynamic">
                @forelse ($items['data'] as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->lastname }}</td>
                    <td>{{ $item->firstname}}</td>
                    <td>{{ $item->patronymic }}</td>
                    <td>
                        @if(!empty($item->getRoleNames()))
                        {{ $item->getRoleNames()[0] }}
                        @endif
                    </td>
                    <td class="d-print-none">
                        <div class="block">
                            <a href="{{ route(config('constants.users.show'),$item->id) }}"
                                class="btn btn-info btn-sm hover">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <span class="hidden">Открыть пользователя</span> <!-- скрытый элемент -->
                        </div>
                        <div class="block">
                            <a href="{{ route(config('constants.users.edit'),$item->id) }}"
                                class="btn btn-success btn-sm hover">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="hidden">Редактировать пользователя</span> <!-- скрытый элемент -->
                        </div>
                        @if (auth()->user()->id !=$item->id)
                        <div class="block">
                            <a data-toggle="modal" data-target="#removeModal-{{ $item->id}}" href="#"
                                class="btn btn-danger btn-sm hover remove"><i class="fas fa-trash"></i></a>
                            <span class="hidden">Удалить кабинет</span> <!-- скрытый элемент -->
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
                                    <form id="formRemove-{{$item->id}}" class="remove-form"
                                        action="{{ route(config('constants.users.destroy'),$item->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <p class="text-center">Вы действительно хотите удалить сотрудника со
                                                    всеми заявками?</p>
                                                <p class="text-center">Перед удалением администраторов убедитесь, что
                                                    есть пользователь c правом superAdmin</p>
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
                        @endif
                    </td>
                </tr>
                @empty
                <tr></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('paginate')
<div class="card-footer clearfix">
    {{ $items['data']->links() }}
</div>
@endsection
