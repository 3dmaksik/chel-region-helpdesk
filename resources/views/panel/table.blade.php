<!-- Simple Tables -->
<div class="card">
	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Все заявки</h6>
	</div>
	<div class="table-responsive">
		<table class="table align-items-center table-flush">
			<thead class="thead-light">
				<tr>
					<th style="width:5%">Номер</th>
					<th style="width:20%">Категория</th>
					<th style="width:1%;">Кабинет</th>
					<th style="width:20%">Сотрудник</th>
					<th style="width:12%">Дата подачи</th>
					<th style="width:12%">Дата выполнения</th>
					<th style="width:10%">Статус</th>
					<th class="d-print-none">Действие</th>
				</tr>
			</thead>
			<tbody id="table-dynamic">
				<tr>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td> <span class="badge badge-info">1</span> </td>
					<td class="d-print-none">
						<div class="block"> <a href="/panel/help/" class="btn btn-info btn-sm hover">
                                                <i class="fas fa-info-circle"></i>
                                            </a> <span class="hidden">Просмотреть заявку</span>
							<!-- скрытый элемент -->
						</div>
						<div class="block"> <a href="/panel/help/update/" class="btn btn-success btn-sm hover">
                                              <i class="fas fa-check"></i>
                                          </a> <span class="hidden">Взять заявку</span>
							<!-- скрытый элемент -->
						</div>
						<div class="block"> <a href="" class="btn btn-danger btn-sm hover" data-toggle="modal" data-target="#closeHelp" data-id="1">
                                                    <i class="fas fa-trash"></i>
                                                </a> <span class="hidden">Отклонить заявку</span>
							<!-- скрытый элемент -->
						</div>
						<div class="block"> <a href="" class="btn btn-success btn-sm hover" data-toggle="modal" data-target="#updateHelp" data-id="1">
                                                    <i class="fas fa-check"></i>
                                                </a> <span class="hidden">Выполнить заявку</span>
							<!-- скрытый элемент -->
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
