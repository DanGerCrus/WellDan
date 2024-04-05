<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Ingredient extends Model
{
    use SoftDeletes;

    protected $table = 'ingredients';
    protected $guarded = [];
    public $timestamps = true;

    public static function getForSelect(): Collection
    {
        $result = collect([
            (object)[
                'value' => '',
                'label' => 'Не выбрано'
            ]
        ]);
        return $result->merge(self::query()->select('id as value', 'name as label')->get());
    }
}
