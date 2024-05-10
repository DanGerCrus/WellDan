<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id')->withTrashed();
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class, 'product_id', 'id');
    }

    public static function autocomplete(): Collection
    {
        $result = collect([
            (object)[
                'value' => '',
                'label' => 'Не выбрано',
                'price' => 0,
            ]
        ]);

        return $result->merge(
            self::query()
                ->select(
                    'id as value',
                    'name as label',
                    'price'
                )
                ->orderBy('products.name')
                ->get()
        );
    }
}
