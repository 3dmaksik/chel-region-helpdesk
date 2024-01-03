<?php

declare(strict_types=1);

namespace App\Catalogs\DTO;

use App\Base\DTO\DTO;
use Illuminate\Http\UploadedFile;

final class AccountDTO extends DTO
{
    public readonly ?UploadedFile $avatar;

    public readonly ?UploadedFile $soundNotify;

    public function __construct(
        ?UploadedFile $avatar = null,
        ?UploadedFile $soundNotify = null,
    ) {
        $this->avatar = $avatar;
        $this->soundNotify = $soundNotify;
    }
}
