@extends('layouts.app')
@section('row')
<!-- Simple Tables -->
<div class="col-lg-12 mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Все кабинеты</h6>
            <a href="{{ route(config('constants.cabinet.create')) }}"> <button type="button"
                    class="btn btn-primary mb-1">Новый кабинет </button></a>
        </div>
        <div class="loader-table">
        @include('loader.cabinet')
        </div>
    </div>
    <div class="card-footer d-flex flex-row justify-content-start clearfix">
        {{ $items['data']->links() }}
    </div>
</div>
@endsection
