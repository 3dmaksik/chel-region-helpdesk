<!-- Simple Tables -->
<div class="card {{ $items['method'] }}">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Все заявки</h6>
        @if(request()->is('home/helps/*'))
        @if(auth()->user()->can('create help') && auth()->user()->can('create home help'))
        <a href="{{ route(config('constants.help.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новая
                заявка</button></a>
        @else
        <a href="{{ route(config('constants.home.create')) }}"> <button type="button" class="btn btn-primary mb-1">Новая
                заявка</button></a>
        @endif
        @endif
        @if (request()->is('search*') && url()->previous()!==url()->current())
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() }}">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a> <span class="hidden">Назад</span>
                <!-- скрытый элемент -->
            </div>
        @endif
    </div>
    <div class="table-responsive loader-table">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th style="width:15%">Номер заявки</th>
                    <th style="width:20%">Категория</th>
                    <th style="width:1%;">Кабинет</th>
                    <th style="width:12%">Сотрудник</th>
                    <th style="width:15%">Дата подачи</th>
                    <th style="width:15%">Контрольная дата</th>
                    <th style="width:15%">Дата выполнения</th>
                    <th style="width:1%">Статус</th>
                    <th class="d-print-none"></th>
                </tr>
            </thead>
            <tbody id="table-dynamic">
                @forelse ($items['data'] as $item)
                <tr @if(strtotime($now)> strtotime($item->calendar_warning) && strtotime($now)< strtotime($item->calendar_execution) && $item->calendar_warning!=null
                && $item->calendar_execution!=null && $item->calendar_final==null && request()->segment(1) != 'user') class="badge-{{config("color.5.slug") }}"@endif
                        @if(strtotime($now)> strtotime($item->calendar_execution) && $item->calendar_execution!=null &&
                        $item->calendar_final==null && request()->segment(1) != 'user') class="badge-{{config("color.4.slug") }}"@endif>
                        <td>@if($item->check_write > 0)<div class="block" style="padding-right: 0.2rem"><i class="fa-solid fa-circle-check hover"></i><span class="hidden"> Просмотрено</span> <!-- скрытый элемент --> </div>@endif{{ $item->app_number }}</td>
                        <td class="badge-table"><div class="block" style="padding-right: 0.2rem"><a class="hover" @can('prefix search') href="{{ route(config('constants.search.category'),$item->category_id) }}"@endcan>
                        {{$item->category->description }}</a><span class="hidden">Открыть категорию</span> <!-- скрытый элемент --> </div></td>
                        <td class="badge-table"><div class="block" style="padding-right: 0.2rem"><a class="hover" @can('prefix search') href="{{ route(config('constants.search.cabinet'),$item->user->cabinet->id) }}"@endcan>
                        {{ $item->user->cabinet->description }}</a><span class="hidden">Открыть кабинет</span> <!-- скрытый элемент --> </div></td>
                        <td class="badge-table"><div class="block" style="padding-right: 0.2rem"><a class="hover" @can('prefix search') href="{{ route(config('constants.search.work'),$item->user_id) }}"@endcan>
                        {{$item->user->lastname }} <br/> {{ $item->user->firstname }} <br/> {{ $item->user->patronymic }}</a>
                        <span class="hidden">Открыть сотрудника</span> <!-- скрытый элемент --> </div>
                        </td>
                        <td>{{ $item->calendar_request}}</td>
                        <td>
                            @if ($item->calendar_execution==null)
                            Дата неопределена
                            @else
                            {{ $item->calendar_execution }}
                            @endif
                        </td>
                        <td>
                            @if ($item->calendar_final==null)
                            Дата неопределена
                            @else
                            {{ $item->calendar_final }}
                            @endif
                        </td>
                        <td><span class="badge badge-{{ $item->status->color }}">{{ $item->status->description }}</span>
                        </td>
                        <td class="d-print-none">
                            <div class="block">
                                @if(auth()->user()->can('create help') && auth()->user()->can('create home help'))
                                <a href="{{ route(config('constants.help.show'), $item->help_id ? $item->help_id : $item->id) }}"> <button type="button"
                                        class="btn btn-info mb-1">Открыть</button></a>
                                @else
                                <a href="{{ route(config('constants.home.show'),$item->help_id ? $item->help_id : $item->id) }}"> <button type="button"
                                        class="btn btn-info mb-1">Открыть</button></a>
                                @endif
                            </div>
                        </td>
                </tr>
                @empty
                <tr></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex flex-row justify-content-start clearfix">
        {{ $items['data']->links() }}
    </div>
    <div class="current-page" style="display: none">{{ $items['data']->currentPage() }}</div>
</div>
