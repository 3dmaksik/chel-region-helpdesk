<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cabinet extends Model
{
    use HasFactory;

    protected $table = 'cabinet';

    protected $primaryKey = 'id';

    protected $fillable = ['description'];

    protected function getCacheBaseTags(): array
    {
        return [
            'cabinet',
        ];
    }
}
