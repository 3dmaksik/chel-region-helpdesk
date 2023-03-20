@extends('layouts.app')
@section('components.grid')
col-lg-12
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Новость</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config('constants.news.index')) }}">
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
        <h3 class="text-primary">{{ $item->name }}</h3>
        <h6 class="text-primary">{{ $item->description }}</h6>
        <hr>
        <div>{!! $item->news_text !!}</div>
        <hr>
        <h6 class="text-primary">Дата публикации:</h6>
        <h6>{{ date( 'd.m.Y H:i', strtotime($item->created_at))}}</h6>
    </div>
  </div>
@endsection
