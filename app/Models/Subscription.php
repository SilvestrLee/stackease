<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'concierge_request_id',
        'invoice_id',
        'subscription_reference',
        'provider_name',
        'plan_type',
        'seat_count',
        'start_date',
        'renewal_date',
        'amount',
        'currency',
        'status',
        'access_note',
        'internal_note',
    ];

    protected function casts(): array
    {
        return [
            'seat_count' => 'integer',
            'start_date' => 'date',
            'renewal_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function conciergeRequest(): BelongsTo
    {
        return $this->belongsTo(ConciergeRequest::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function credential(): HasOne
    {
        return $this->hasOne(SubscriptionCredential::class);
    }

    public function acknowledgments(): HasMany
    {
        return $this->hasMany(Acknowledgment::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }
}