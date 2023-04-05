<?php

namespace App\Core\Repositories;

abstract class CoreRepository
{
    protected $model;

    //Получение модели
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    // Обязательная реализация в конкрентном репозитории
    abstract protected function getModelClass();

    abstract protected function start();

    abstract protected function getAllRepository();

    abstract protected function getAllRepositoryPaginate(int $page);

    abstract protected function getRepository();

    abstract protected function viewRepository(int $id);
}
