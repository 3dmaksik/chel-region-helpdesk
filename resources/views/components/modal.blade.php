<div id="modal-forms">
<!-- Окно редактирования-->
<div class="modal fade" id="editHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование заявки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formEdit" class="form-submit" action="{{ route(config('constants.help.update'),$item['data']->id,'update') }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <div id="sent-message-update" style="display: none"> </div>
                        </div>
                        <label for="select2-category">Изменить категорию</label>
                        <select class="select2-single form-control" name="category_id" id="update-select2-category">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select2-user">Изменить сотрудника</label>
                        <select class="select2-single select2-user form-control" name="user_id" id="update-select2-user">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select2-priority">Изменить приоритет</label>
                        <select class="select2-single form-control" name="priority_id" id="update-select2-priority">
                        </select>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-success update-submit" type="submit" value="Изменить" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Окно принятия-->
<div class="modal fade" id="acceptHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Принятие заявки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formAccept" class="form-submit"
                action="{{ route(config('constants.help.accept'),$item['data']->id,'accept') }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <div id="sent-message-accept" style="display: none"> </div>
                        </div>
                        <label for="accept-select2-user">Назначить исполнителя</label>
                        <select class="select2-single form-control" name="executor_id"
                            id="accept-select2-user"></select>
                    </div>
                    <div class="form-group">
                        <label for="accept-select2-priority">Назначить приоритет</label>
                        <select class="select2-single form-control" name="priority_id"
                            id="accept-select2-priority"></select>
                    </div>
                    <div class="form-group">
                        <label for="accept-info">Информация для выполнения</label>
                        <textarea class="form-control form-modal-info" id="accept-info" rows="3" name="info"></textarea>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-success update-submit" type="submit" value="Назначить" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Окно выполнения-->
<div class="modal fade" id="executeHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Выполнение заявки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formExecute" enctype="multipart/form-data" class="form-submit" action="{{ route(config('constants.help.execute'),$item['data']->id,'execute') }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <div id="sent-message-execute" style="display: none"> </div>
                        </div>
                        <label for="execute-info">Информация о выполнении</label>
                        <textarea class="form-control form-modal-info" id="execute-info" rows="3"
                            name="info_final"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="images-final">Загрузите фото или скриншоты если необходимо</label>
                        <div class="custom-file">
                            <label class="custom-file-label" for="customFile">Выберите файлы</label>
                            <input type="file" name="images_final[]" class="custom-file-input" id="customFileFinal"
                                accept="image/png, image/jpeg" multiple />
                        </div>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-success update-submit" type="submit" value="Выполнить" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Окно передачи-->
<div class="modal fade" id="redefineHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Передача заявки другому исполнителю</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formRedefine" class="form-submit" action="{{ route(config('constants.help.redefine'),$item['data']->id,'redefine') }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <div id="sent-message-redefine" style="display: none"> </div>
                        </div>
                        <label for="redefine-select2-user">Назначить исполнителя</label>
                        <select class="select2-single form-control" name="executor_id"
                            id="redefine-select2-user"></select>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-success update-submit" type="submit" value="Передать" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Окно отклонения-->
<div class="modal fade" id="rejectHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Отклонение заявки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formReject" class="form-submit" action="{{ route(config('constants.help.reject'),$item['data']->id,'reject') }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <div id="sent-message-reject" style="display: none"> </div>
                        </div>
                        <label for="reject-info">Информация о причинах отклонения</label>
                        <textarea class="form-control form-modal-info" id="reject-info" rows="3"
                            name="info_final"></textarea>
                    </div>
                </div>
                <div class="modal-footer form-group">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                    <input class="btn btn-danger update-submit" type="submit" value="Отклонить" />
                </div>
            </form>
        </div>
    </div>
</div>

</div>
