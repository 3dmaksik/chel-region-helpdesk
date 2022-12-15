<?php

namespace App\Base\Helpers;

use App\Base\Models\Model;
use App\Core\Helpers\CoreHelper;
use Illuminate\Http\RedirectResponse;

class RedirectHelper extends CoreHelper
{
    public static function redirect(Model | bool $result, string $routeData, int $id = null): RedirectResponse
    {
        if ($id > 0) {
            return ($result) ? self::routeWithId($routeData, $id) : self::backWithError();
        } else {
            return ($result) ? self::routeWithoutId($routeData) : self::backWithError();
        }
    }

    protected static function routeWithId(string $routeData, int $id): RedirectResponse
    {
        return redirect()->route($routeData, $id)->with(['success' => 'Сохранено']);
    }

    protected static function routeWithoutId(string $routeData): RedirectResponse
    {
        return redirect()->route($routeData)->with(['success' => 'Сохранено']);
    }

    protected static function backWithError()
    {
        return back()->withErrors(['msg' => 'Не сохранено'])->withInput();
    }
}
