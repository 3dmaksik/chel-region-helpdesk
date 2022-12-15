@extends('layouts.app')
@section('components.grid')
col-lg-12
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Редактировать заявку</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config($generateNames.'.index')) }}">
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
        <form id="formValidate" method="POST" action="{{ route(config($generateNames.'.update'),$item->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="select2-category">Изменить категорию</label>
            <select class="select2-single form-control" name="category_id" id="select2-category">
              @foreach( $data['category'] as $category)
              <option @if ($category->id==$item->category->id) selected @endif value="@if ($category->id==$item->category->id) {{ $item->category->id }} @else {{ $category->id }}@endif">@if ($category->id==$item->category->id) {{ $item->category->description }} @else {{ $category->description }}@endif</option>
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="select2-cabinet">Изменить кабинет</label>
            <select class="select2-single form-control" name="cabinet_id" id="select2-cabinet">
              @foreach( $data['cabinet'] as $cabinet)
              <option @if ($cabinet->id==$item->cabinet->id) selected @endif value="@if ($cabinet->id==$item->cabinet->id) {{ $item->cabinet->id }} @else {{ $cabinet->id }}@endif">@if ($cabinet->id==$item->cabinet->id) {{ $item->cabinet->description }} @else {{ $cabinet->description }}@endif</option>
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="select2-work">Изменить сотрудника</label>
            <select class="select2-single form-control" name="work_id" id="select2-work">
              @foreach( $data['work'] as $work)
              <option @if ($work->id==$item->work->id) selected @endif value="@if ($work->id==$item->work->id) {{ $item->work->id }} @else {{ $work->id }}@endif">@if ($work->id==$item->work->id) {{ $item->work->lastname }} {{ $item->work->firstname }} {{ $item->work->patronymic }} @else {{ $work->lastname }} {{ $work->firstname }} {{ $work->patronymic }}@endif</option>
              @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="select2-priority">Изменить приоритет</label>
            <select class="select2-single form-control" name="priority_id" id="select2-priority">
                @foreach( $data['priority'] as $priority)
                <option @if ($priority->id==$item->priority->id) selected @endif value="@if ($priority->id==$item->priority->id) {{ $item->priority->id }} @else {{ $priority->id }}@endif">@if ($priority->id==$item->priority->id) {{ $item->priority->description }} @else {{ $priority->description }}@endif</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="select2-description-long">Введите описание к выполнению заявки</label>
            <textarea class="form-control @error('info') is-invalid @enderror" id="select2-info" rows="3" name="info">{{ $item->info }}</textarea>
            @error('info')
            <small class="invalid-feedback">Текст не введён</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="select2-description-long">Описание заявки</label>
            <p>{{ $item->description_long }}</p>
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ route(config($generateNames.'.index')) }}">Отменить</a>
      </form>
    </div>
  </div>
@endsection
