@extends('layouts.app')
@section('row')
<div class="col-lg-12 mb-4">
<!-- Simple Tables -->
<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Все статусы</h6>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th style="width: 50%">Статус</th>
                    <th class="d-print-none" style="width: 40%">Цвет</th>
                    <th class="d-print-none"></th>
                </tr>
            </thead>
            <tbody id="table-dynamic">
                @forelse ($items['data'] as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>
                        <div style="height: 40px;width: 185px" class="d-print-none card bg-{{ $item->color }}"></div>
                    </td>
                    <td class="d-print-none">
                        <div class="block">
                            <a href="{{ route(config('constants.status.edit'),$item->id) }}"
                                class="btn btn-success btn-sm hover">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="hidden">Редактировать статус</span> <!-- скрытый элемент -->
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
