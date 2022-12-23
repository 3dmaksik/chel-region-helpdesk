<?php

namespace App\Help\Helpers;

use App\Core\Helpers\CoreHelper;
use App\Models\Help;

class CheckHelpHelper extends CoreHelper
{
    public Help $help;

    public static function checkUpdate(int $id, bool $status = true): bool
    {
        $help = Help::find($id);
        return $help->update(['check_write' => $status]);
    }
}
