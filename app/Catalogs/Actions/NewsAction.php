<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Article as Model;

class NewsAction extends Action
{
    private array $news;

    private int $total;

    public function getAllPagesPaginate(): array
    {
        $this->item = new Model();
        $this->items = Model::dontCache()->orderBy('created_at', 'DESC')->paginate($this->page);
        $this->total = Model::count();
        $this->news =
        [
            'data' => $this->items,
            'total' => $this->total,
        ];

        return $this->news;
    }

    public function findCatalogsById(int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);

        return $this->item;
    }

    public function show(int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);

        return $this->item;
    }

    public function store(array $request): bool
    {
        Model::dontCache()->create($request);

        return true;
    }

    public function update(array $request, int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->item->dontCache()->update($request);

        return $this->item;
    }

    public function delete(int $id): bool
    {
        $this->item = Model::dontCache()->findOrFail($id);

        return true;
    }
}
