@extends('layouts.app')
@section('components.grid')
col-lg-12 mb-4
@endsection
@section('row')
<!-- Simple Tables -->
<div class="card">
	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Все сотрудники</h6>
        <a href="{{ route(config($generateNames.'.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новый сотрудник </button></a>
	</div>
	<div class="table-responsive">
		<table class="table align-items-center table-flush">
			<thead class="thead-light">
				<tr>
					<th style="width: 30%">Фамилия</th>
                    <th style="width: 30%">Имя</th>
                    <th style="width: 29%">Отчество</th>
                    <th class="d-print-none"></th>
				</tr>
			</thead>
			<tbody id="table-dynamic">
                @forelse ($items as $item)
				<tr>
					<td>{{ $item->lastname }}</td>
                    <td>{{ $item->firstname}}</td>
                    <td>{{ $item->patronymic }}</td>
					<td class="d-print-none">
                        <div class="block">
                            <a href="{{ route(config($generateNames.'.show'),$item->id) }}" class="btn btn-info btn-sm hover">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <span class="hidden">Открыть сотрудника</span> <!-- скрытый элемент -->
                        </div>
						<div class="block">
                            <a href="{{ route(config($generateNames.'.edit'),$item->id) }}" class="btn btn-success btn-sm hover">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="hidden">Редактировать сотрудника</span> <!-- скрытый элемент -->
                        </div>
                        <div class="block">
                            <a href="{{ route(config($generateNames.'.edit'),$item->id) }}" class="btn btn-danger btn-sm hover">
                                <i class="fas fa-trash"></i>
                            </a>
                            <span class="hidden">Удалить сотрудника</span> <!-- скрытый элемент -->
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
@endsection
@section('paginate')
<div class="card-footer clearfix">
    {{ $items->links() }}
</div>
@endsection
