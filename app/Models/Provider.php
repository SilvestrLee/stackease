<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'website_url',
        'provider_type',
        'risk_level',
        'allowed_status',
        'description',
        'admin_notes',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function conciergeRequests(): HasMany
    {
        return $this->hasMany(ConciergeRequest::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}