<!-- Simple Tables -->
<div class="card {{ $items['method'] }}">
	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Все заявки</h6>
        @hasanyrole('superAdmin|admin')
        <a href="{{ route(config('constants.help.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новая заявка</button></a>
        @endhasanyrole
        @hasrole('manager|user')
        <a href="{{ route(config('constants.home.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новая заявка</button></a>
        @endhasrole
	</div>
	<div class="table-responsive">
		<table class="table align-items-center table-flush">
			<thead class="thead-light">
				<tr>
                    <th style="width:10%">Номер</th>
                    <th style="width:15%">Категория</th>
                    <th style="width:1%;">Кабинет</th>
                    <th style="width:15%">Сотрудник</th>
                    <th style="width:12%">Дата подачи</th>
                    <th style="width:12%">Дата выполнения</th>
                    <th style="width:12%">Контрольная дата</th>
                    <th style="width:10%">Статус</th>
                    <th class="d-print-none"></th>
				</tr>
			</thead>
			<tbody id="table-dynamic">
                @forelse ($items['data'] as $item)
				<tr
                @if(strtotime($now)> strtotime($item->calendar_warning) && strtotime($now)< strtotime($item->calendar_execution) && $item->calendar_warning!=null && $item->calendar_execution!=null && $item->calendar_final==null && request()->segment(1) != 'user') class="badge-{{ config("color.5.slug") }}"@endif
                @if(strtotime($now)> strtotime($item->calendar_execution) && $item->calendar_execution!=null && $item->calendar_final==null && request()->segment(1) != 'user') class="badge-{{ config("color.4.slug") }}"@endif
                >
					<td>{{ $item->app_number }}</td>
                    <td class="badge-table"><a href="{{ route('search.category',$item->category_id) }}">{{ $item->category->description }}</a></td>
                    <td class="badge-table"><a href="{{ route('search.cabinet',$item->user->cabinet->id) }}">{{ $item->user->cabinet->description }}</a></td>
                    <td class="badge-table"><a href="{{ route('search.work',$item->user_id) }}">{{ $item->user->lastname }} {{ $item->user->firstname }} {{ $item->user->patronymic }}</a></td>
                    <td>{{ date( 'd.m.Y H:i', strtotime($item->calendar_request))}}</td>
                    <td>
                        @if ($item->calendar_final==null)
                        Дата неопределена
                        @else
                        {{ date( 'd.m.Y H:i', strtotime($item->calendar_final)) }}
                        @endif
                    </td>
                    <td>
                        @if ($item->calendar_execution==null)
                        Дата неопределена
                        @else
                        {{ date( 'd.m.Y H:i', strtotime($item->calendar_execution))}}
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $item->status->color }}">{{ $item->status->description }}</span></td>
					<td class="d-print-none">
						<div class="block">
                            @hasanyrole('superAdmin|admin|manager')
                            <a href="{{ route(config('constants.help.show'),$item->id) }}"> <button type="button" class="btn btn-info mb-1">Открыть</button></a>
                            @endhasanyrole
                            @hasrole('user')
                            <a href="{{ route(config('constants.home.show'),$item->id) }}"> <button type="button" class="btn btn-info mb-1">Открыть</button></a>
                            @endhasrole
                        </div>
					</td>
				</tr>
                @empty
                <tr></tr>
                @endforelse
			</tbody>
		</table>
	</div>
    <div class="card-footer clearfix">
        {{ $items['data']->links() }}
    </div>
    <div class="current-page" style="display: none">{{ $items['data']->currentPage() }}</div>
</div>
