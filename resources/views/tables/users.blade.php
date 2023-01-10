@extends('layouts.app')
@section('components.grid')
col-lg-12 mb-4
@endsection
@section('row')
<!-- Simple Tables -->
<div class="card">
	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Все пользователи</h6>
        <a href="{{ route(config('constants.users.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новый пользователь </button></a>
	</div>
	<div class="table-responsive">
		<table class="table align-items-center table-flush">
			<thead class="thead-light">
				<tr>
					<th style="width: 59%">Логин</th>
                    <th style="width: 30%">Роль</th>
                    <th class="d-print-none"></th>
				</tr>
			</thead>
			<tbody id="table-dynamic">
                @forelse ($items as $item)
				<tr>
					<td>{{ $item->name }}</td>
                    <td>
                        @if(!empty($item->getRoleNames()))
                        {{  $item->getRoleNames()[0] }}
                        @endif
                    </td>
					<td class="d-print-none">
                        <div class="block">
                            <a href="{{ route(config('constants.users.show'),$item->id) }}" class="btn btn-info btn-sm hover">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <span class="hidden">Открыть пользователя</span> <!-- скрытый элемент -->
                        </div>
						<div class="block">
                            <a href="{{ route(config('constants.users.edit'),$item->id) }}" class="btn btn-success btn-sm hover">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="hidden">Редактировать пользователя</span> <!-- скрытый элемент -->
                        </div>
                        <div class="block">
                            <a href="{{ route(config('constants.users.edit'),$item->id) }}" class="btn btn-danger btn-sm hover">
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
