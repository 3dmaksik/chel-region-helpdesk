<?php

namespace App\Models;

use App\Base\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $primaryKey = 'id';

    protected $fillable = ['description'];

    protected function getCacheBaseTags(): array
    {
        return [
            'category',
        ];
    }
}
