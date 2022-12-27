<?php

namespace App\Base\Models;

use App\Core\Models\CoreModel;
use Illuminate\Database\Eloquent\Builder;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Model extends CoreModel
{
    use QueryCacheable;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $timestamps = true;
    public int $page = 25;
    protected $cacheFor = 10080;

    public function getAllPaginateItems()
    {
        return $this->setOrder($this)->paginate($this->page);
    }

    public function viewOneItem(int $id)
    {
        return $this->findOrFail($id);
    }

    public function getAllItems()
    {
        return $this->setOrder($this)->get();
    }

    protected function setOrder(): Builder
    {
        return $this->orderBy('description', 'ASC');
    }
}
