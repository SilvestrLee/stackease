<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionCredential extends Model
{
    protected $fillable = [
        'subscription_id',
        'encrypted_access_payload',
        'payload_type',
        'last_viewed_at',
        'last_viewed_by',
    ];

    protected function casts(): array
    {
        return [
            'last_viewed_at' => 'datetime',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function lastViewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_viewed_by');
    }
}