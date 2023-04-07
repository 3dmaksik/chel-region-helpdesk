@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Статистика за {{ $now->year }} год</h6>
        <div class="card-title">
            <div class="block d-print-none">
                <a style="color: #757575;" class="hover" href="javascript:(print());">
                    <i class="fas fa-print fa-lg"></i>
                </a> <span class="hidden">Печать</span>
                <!-- скрытый элемент -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="text-primary">Всего заявок за месяц</p>
        <p>{{ $data['month'] }} шт</p>
        <p class="text-primary">Всего заявок за год</p>
        <p>{{ $data['year'] }} шт</p>
        <p class="text-primary">Самая активная категория</p>
        @if ($data['active_work'] !=null)
        <p>{{ $data['active_category']->description }}</p>
        @else
        <p>Активная категория отсуствует</p>
        @endif
        <p class="text-primary">Самый активный сотрудник</p>
        @if ($data['active_work'] !=null)
        <p>{{ $data['active_work']->lastname }} {{ $data['active_work']->firstname }} {{
            $data['active_work']->patronymic }}</p>
        @else
        <p>Активный сотрудник отсуствует</p>
        @endif
        <p class="text-primary">Самый отклоняемый сотрудник</p>
        @if ($data['error_work'] !=null)
        <p>{{ $data['error_work']->lastname }} {{ $data['error_work']->firstname }} {{ $data['error_work']->patronymic}}</p>
        @else
        <p>Отклоняемый сотрудник отсуствует</p>
        @endif
    </div>
</div>
@endsection
