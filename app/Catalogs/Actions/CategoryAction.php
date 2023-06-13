<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Category as Model;
use App\Models\Help;
use Illuminate\Http\JsonResponse;

class CategoryAction extends Action
{
    /**
     * [result category]
     */
    private array $response;

    /**
     * [count help for category]
     */
    private int $countHelp;

    /**
     * [all category with count items on page]
     */
    public function getAllPagesPaginate(): array
    {
        $this->item = new Model();
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        $this->response =
        [
            'data' => $this->items,
        ];

        return $this->response;
    }

    /**
     * [show one category]
     */
    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    /**
     * [add new category]
     */
    public function store(array $request): JsonResponse
    {
        Model::create($request);
        $this->response = [
            'message' => 'Категория успешно добавлена!',
        ];

        return response()->success($this->response);
    }

    /**
     * [update category]
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Категория успешно обновлена!',
        ];

        return response()->success($this->response);
    }

    /**
     * [delete category if there are no help]
     */
    public function delete(int $id): JsonResponse
    {
        $this->countHelp = Help::dontCache()->where('category_id', $id)->count();
        if ($this->countHelp > 0) {
            $this->response = [
                'message' => 'Категория не может быть удалена, так как не удалены все заявки связанные с ней!',
                'reload' => true,
            ];

            return response()->error($this->response);
        }
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        $this->response = [
            'message' => 'Категория успешно удалена!',
        ];

        return response()->success($this->response);
    }
}
