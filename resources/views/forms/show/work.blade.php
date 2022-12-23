@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Просмотр сотрудника</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config('constants.work.index')) }}">
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
        <p class="text-primary">Фамилия</p>
        <p>{{ $item->lastname }}</p>
        <p class="text-primary">Имя</p>
        <p>{{ $item->firstname}}</p>
        <p class="text-primary">Отчество</p>
        @empty ($item->patronymic)
        <p>Нет отчества</p>
        @else
        <p>{{ $item->patronymic}}</p>
        @endempty
    </div>
  </div>
@endsection
