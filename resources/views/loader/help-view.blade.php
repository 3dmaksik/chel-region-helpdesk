<div class="col-lg-12 mb-4">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Информация о заявке</h6>
        <div class="card-title">
            @if (url()->previous()!==url()->current())
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() }}">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a> <span class="hidden">Назад</span>
                <!-- скрытый элемент -->
            </div>
            @else
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" href="{{ route(config('constants.news.index')) }}">
                     <i class="fas fa-close fa-lg"></i>
                </a> <span class="hidden">На главную</span>
                    <!-- скрытый элемент -->
            </div>
            @endif
            <div class="block d-print-none">
                <a style="color: #757575;margin-right: 10px" class="hover" href="javascript:(print());">
                    <i class="fas fa-print fa-lg"></i>
                </a> <span class="hidden">Печать</span>
                <!-- скрытый элемент -->
            </div>
        </div>
    </div>
    @include('/loader/help-view-body')
</div>
</div>
