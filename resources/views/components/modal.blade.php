@if(request()->segment(2) == 'help' && isset($item->id))
<!-- Окно принятия-->
<div class="modal fade" id="acceptHelp" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Принятие заявки</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <form class="update-form" action="{{ route(config($generateNames.'.accept'),$item->id,'accept') }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="accept-select2-work">Назначить исполнителя</label>
                  <select class="select2-single form-control" name="executor_id" id="accept-select2-work"></select>
               </div>
               <div class="form-group">
                  <label for="accept-select2-work">Назначить приоритет</label>
                  <select class="select2-single form-control" name="priority_id" id="accept-select2-priority"></select>
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
      </div>
      </form>
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
         <form class="update-form" action="{{ route(config($generateNames.'.execute'),$item->id,'execute') }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="execute-info">Информация о выполнении</label>
                  <textarea class="form-control form-modal-info" id="execute-info" rows="3" name="info_final"></textarea>
               </div>
            </div>
            <div class="modal-footer form-group">
               <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
               <input class="btn btn-success update-submit" type="submit" value="Выполнить" />
            </div>
      </div>
      </form>
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
          <form class="update-form" action="{{ route(config($generateNames.'.redefine'),$item->id,'redefine') }}" method="POST">
             @method('PATCH')
             @csrf
             <div class="modal-body">
                <div class="form-group">
                    <label for="redefine-select2-work">Назначить исполнителя</label>
                    <select class="select2-single form-control" name="executor_id" id="redefine-select2-work"></select>
                 </div>
             </div>
             <div class="modal-footer form-group">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                <input class="btn btn-success update-submit" type="submit" value="Передать" />
             </div>
       </div>
       </form>
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
          <form class="update-form" action="{{ route(config($generateNames.'.reject'),$item->id,'reject') }}" method="POST">
             @method('PATCH')
             @csrf
             <div class="modal-body">
                <div class="form-group">
                   <label for="reject-info">Информация о причинах отклонения</label>
                   <textarea class="form-control form-modal-info" id="reject-info" rows="3" name="info_final"></textarea>
                </div>
             </div>
             <div class="modal-footer form-group">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отменить</button>
                <input class="btn btn-danger update-submit" type="submit" value="Отклонить" />
             </div>
       </div>
       </form>
    </div>
 </div>
 @endif
