<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class CatalogsAction extends Action
{
    private bool $item;
    private Collection | LengthAwarePaginator $pages;
    public function getAllCatalogs(Model $model, int $page = null): Collection | LengthAwarePaginator
    {
        ($page == null) ? $this->pages = $model->getAllItems() : $this->pages = $model->getAllPaginateItems($page);
        //Запуск модели через репозиторий
        return $this->pages;
    }

    public function findCatalogsById(Model $model, int $id): Model
    {
        return $model->viewOneItem($id);
    }

    public function show(Model|SimpleCollection $model): Model|SimpleCollection
    {
        if (isset($model->images)) {
            $model->images = json_decode($model->images, true);
        }
        return $model;
    }

    public function store(array $request, Model $model): Model
    {
        Model::flushQueryCache();
        //Запуск таска для создания записи, через репозиторий
        return ($model)->create($request);
    }

    public function update(array $request, Model $model): bool
    {
        //Запуск таска для обновления записи, передача request с новыми данными
        $this->item = $model->update($request);
        //Запуск функции для очистки кеша
        Model::flushQueryCache();
        return $this->item;
    }

    public function delete(Model $model): bool
    {
        //Запуск таска для удаления записи
        $this->item = $model->forceDelete();
        //Запуск функции для очистки кеша
        Model::flushQueryCache();
        return $this->item;
    }
}
