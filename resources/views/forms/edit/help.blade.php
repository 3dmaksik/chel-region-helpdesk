@extends('layouts.app')
@section('row')
<div class="col-lg-12">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Редактировать заявку</h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" onclick="window.history.back()">
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
        <form id="formValidate" class="form-submit" method="POST" action="{{ route(config('constants.help.update'),$items['item']->id) }}">
            @method('PATCH')
            <div class="form-group">
                <div class="form-group">
                    <label for="select2-category">Изменить категорию</label>
                    <select class="select2-single form-control" name="category_id" id="select2-category">
                        @foreach( $items['data']['category'] as $category)
                        <option
                            value="@if ($category->id==$items['item']->category->id) {{ $items['item']->category->id }} @else {{ $category->id }}@endif">
                            @if ($category->id==$items['item']->category->id) {{ $items['item']->category->description}} @else {{ $category->description }}@endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="select2-user">Изменить сотрудника</label>
                    <select class="select2-single form-control" name="user_id" id="select2-user">
                        @foreach( $items['data']['user'] as $user)
                        <option
                            value="@if ($user->id==$items['item']->user->id) {{ $items['item']->user->id }} @else {{ $user->id }}@endif">
                            @if ($user->id==$items['item']->user->id) {{ $items['item']->user->lastname }} {{
                            $items['item']->user->firstname }} {{ $items['item']->user->patronymic }}
                            @else {{ $user->lastname }} {{ $user->firstname }} {{ $user->patronymic }}@endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="select2-priority">Изменить приоритет</label>
                    <select class="select2-single form-control" name="priority_id" id="select2-priority">
                        @foreach( $items['data']['priority'] as $priority)
                        <option
                            value="@if ($priority->id==$items['item']->priority->id) {{ $items['item']->priority->id }} @else {{ $priority->id }}@endif">
                            @if ($priority->id==$items['item']->priority->id) {{ $items['item']->priority->description}}
                            @else {{ $priority->description }}@endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="select2-description-long">Описание заявки</label>
                    <p>{{ $items['item']->description_long }}</p>
                </div>
                <input class="btn btn-primary" type="submit" value="Отправить" />
                <a class="btn btn-secondary" href="{{ url()->previous() }}">Отменить</a>
        </form>
    </div>
</div>
</div>
@endsection
