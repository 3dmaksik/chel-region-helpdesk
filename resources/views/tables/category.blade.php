@extends('layouts.app')
@section('components.grid')
col-lg-12 mb-4
@endsection
@section('row')
<!-- Simple Tables -->
<div class="card">
	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Все категории</h6>
        <a href="{{ route(config('constants.category.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новая категория</button></a>
	</div>
	<div class="table-responsive">
		<table class="table align-items-center table-flush">
			<thead class="thead-light">
				<tr>
					<th style="width: 90%">Категория</th>
                    <th class="d-print-none"></th>
				</tr>
			</thead>
			<tbody id="table-dynamic">
                @forelse ($items as $item)
				<tr>
					<td>{{ $item->description }}</td>
					<td class="d-print-none">
						<div class="block">
                            <a href="{{ route(config('constants.category.edit'),$item->id) }}" class="btn btn-success btn-sm hover">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="hidden">Редактировать категорию</span> <!-- скрытый элемент -->
                        </div>
                     <form method="POST" style="display: inline" action="{{ route(config('constants.category.destroy'),$item->id) }}">
                        <div class="block">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm hover">
                                        <i class="fas fa-trash"></i>
                                </button>
                            <span class="hidden">Удалить категорию</span> <!-- скрытый элемент -->
                        </div>
                    </form>
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
