<?php

return
[
    'cabinet' =>
        [
            'name' => 'кабинет',
            'slug' => 'cabinet',
            'index' => 'cabinet.index',
            'show' => 'cabinet.show',
            'create' => 'cabinet.create',
            'edit' => 'cabinet.edit',
            'store' => 'cabinet.store',
            'update' => 'cabinet.update',
            'destroy' => 'cabinet.destroy'
        ],
    'category' =>
        [
            'name' => 'категория',
            'slug' => 'category',
            'index' => 'category.index',
            'show' => 'category.show',
            'create' => 'category.create',
            'edit' => 'category.edit',
            'store' => 'category.store',
            'update' => 'category.update',
            'destroy' => 'category.destroy'
        ],
    'priority' =>
        [
            'name' => 'приоритет',
            'slug' => 'priority',
            'index' => 'priority.index',
            'show' => 'priority.show',
            'create' => 'priority.create',
            'edit' => 'priority.edit',
            'store' => 'priority.store',
            'update' => 'priority.update',
            'destroy' => 'priority.destroy'
        ],
    'work' =>
        [
            'name' => 'сотрудник',
            'slug' => 'work',
            'index' => 'work.index',
            'show' => 'work.show',
            'create' => 'work.create',
            'edit' => 'work.edit',
            'store' => 'work.store',
            'update' => 'work.update',
            'destroy' => 'work.destroy'

        ],
    'status' =>
        [
            'name' => 'статус',
            'slug' => 'status',
            'index' => 'status.index',
            'show' => 'status.show',
            'create' => 'status.create',
            'edit' => 'status.edit',
            'store' => 'status.store',
            'update' => 'status.update',
            'destroy' => 'status.destroy'
        ],
    'help' =>
        [
            'name' => 'заявка',
            'slug' => 'help',
            'index' => 'help.index',
            'show' => 'help.show',
            'create' => 'help.create',
            'edit' => 'help.edit',
            'store' => 'help.store',
            'update' => 'help.update',
            'destroy' => 'help.destroy',
            //принять заявку
            'accept' => 'help.accept',
            //выполнить заявку
            'execute' => 'help.execute',
            //отклонить заявку
            'reject' => 'help.reject',
            //переопределить заявку
            'redefine' => 'help.redefine'
        ],
];
