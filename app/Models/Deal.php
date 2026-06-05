<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    protected $fillable = [
        'provider_id',
        'category_id',
        'created_by',
        'title',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'deal_price',
        'discount_percent',
        'deal_url',
        'badge',
        'starts_at',
        'expires_at',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'deal_price' => 'decimal:2',
        'discount_percent' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}