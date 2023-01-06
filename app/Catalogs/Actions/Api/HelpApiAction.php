<?php

namespace App\Catalogs\Actions\Api;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Models\Help;
use Illuminate\Database\Eloquent\Collection;

class HelpApiAction extends Action
{
    const workHelp = 1;
    const newHelp = 2;
    const successHelp = 3;
    const dangerHelp = 4;
    public function getAllCatalogsCollection() : Collection
    {
         $this->data = AllCatalogsDTO::getAllCatalogsCollection();
        return $this->data;
    }

    public function updateView(int $id, bool $status = true) :bool
    {
        return Help::whereId($id)->update(['check_write' => $status]);
    }

    public function getNewPagesCount() :  int
    {
         return Help::where('status_id', self::newHelp)->count();
    }

    public function getNowPagesCount() :  int
    {
        return Help::where('status_id', self::workHelp)
        ->where('executor_id', auth()->user()->id)->count();
    }
}
