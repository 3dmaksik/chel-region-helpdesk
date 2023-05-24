<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Журнал заявок</h1>
    <div class="p-2">
        <h6 class="total">@if(isset($items) && isset($items['data']) && $items['data']->total()!=null )Всего записей: {{ $items['data']->total() }} @endif</h6>
    </div>
</div>
