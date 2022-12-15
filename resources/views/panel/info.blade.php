<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
	<h6 class="m-0 font-weight-bold text-primary">Просмотр заявки</h6>
	<div class="card-title">
		<div class="block"> <a style="color: #757575;" class="hover" href="{{ URL::previous() }}">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a> <span class="hidden">Назад</span>
			<!-- скрытый элемент -->
		</div>
		<div class="block d-print-none"> <a style="color: #757575;" class="hover" href="javascript:(print());">
                <i class="fas fa-print fa-lg"></i>
            </a> <span class="hidden">Печать</span>
			<!-- скрытый элемент -->
		</div>
	</div>
</div>
<div class="card-body">
	<form id="formValidate" method="POST" action="#">
		<div class="form-group"> <label for="">Номер</label> <input type="text" name="description" value="1" class="form-control is-invalid" id="description" aria-describedby="textHelp" placeholder="Пр. 1" autocomplete="off">
            <small id="textHelp" class="form-text text-muted">Введите номер кабинета</small>
            <small class="invalid-feedback">Такой кабинет уже существует или неправильно указано число</small> </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ URL::previous() }}">Отменить</a>
    </form>
</div>
