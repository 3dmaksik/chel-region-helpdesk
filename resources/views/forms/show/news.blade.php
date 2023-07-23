@extends('layouts.app')
@section('row')
<div class="col-lg-12">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Новость № {{ $item['data']->id }}</h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() === url()->current() ? route(config('constants.news.index')): url()->previous()}}">
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
        <h3 class="text-primary">{{ $item['data']->name }}</h3>
        <h6 class="text-primary">{{ $item['data']->description }}</h6>
        <hr>
        <div>{!! $item['data']->news_text !!}</div>
        <hr>
        <h6 class="text-primary">Дата публикации:</h6>
        <h6>{{ $item['data']->created_at }}</h6>
        @can('edit news')
        <a class="btn btn-success" href="{{ route(config('constants.news.edit'), $item['data']->id)}}">Редактировать новость</a>
        @endcan
    </div>
</div>
</div>
@endsection
