@extends('layouts.app')
@section('row')
<div class="col-lg-4">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Информация</h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() === url()->current() ? route(config('constants.priority.index')): url()->previous()}}">
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
        <p class="text-primary">Наименование приоритета</p>
        <p>{{ $item->description }}</p>
        <p class="text-primary">Позиция</p>
        <p>{{ $item->rang }}</p>
        <p class="text-primary">Время до предупреждения</p>
        <p>{{ $item->warning_timer}}ч.</p>
        <p class="text-primary">Время до просрочки</p>
        <p>{{ $item->danger_timer}}ч.</p>
    </div>
</div>
</div>
@endsection
