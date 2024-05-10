<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';
    protected $guarded = [];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id', 'users');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id', 'id', 'users');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(OrderHasProduct::class, 'order_id', 'id');
    }
}
