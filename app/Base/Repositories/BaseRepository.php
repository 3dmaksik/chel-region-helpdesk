<?php

namespace App\Base\Repositories;

use App\Core\Repositories\CoreRepository;

abstract class BaseRepository extends CoreRepository
{
    //Получение существующей модели для работы
    protected function start()
    {
        return clone $this->model;
    }

    //Получение модели
    public function getRepository()
    {
        return $this->start();
    }
}
