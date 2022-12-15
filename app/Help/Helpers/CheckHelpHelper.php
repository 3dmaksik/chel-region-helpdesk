<?php

namespace App\Help\Helpers;

use App\Core\Helpers\CoreHelper;
use App\Models\Help;

class CheckHelpHelper extends CoreHelper
{
    public Help $help;

    public static function checkUpdate(int $id): bool
    {
        $help = Help::find($id);
        return $help->update(['check_write' => true]);
    }
}
