<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'concierge_request_id',
        'invoice_reference',
        'base_usd_cost',
        'fx_rate',
        'fx_buffer_percent',
        'fx_buffer_amount',
        'service_fee',
        'gateway_fee',
        'total_naira_amount',
        'currency',
        'status',
        'sent_at',
        'expires_at',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'base_usd_cost' => 'decimal:2',
            'fx_rate' => 'decimal:2',
            'fx_buffer_percent' => 'decimal:2',
            'fx_buffer_amount' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'gateway_fee' => 'decimal:2',
            'total_naira_amount' => 'decimal:2',
            'sent_at' => 'datetime',
            'expires_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conciergeRequest(): BelongsTo
    {
        return $this->belongsTo(ConciergeRequest::class);
    }

    public function pricingSnapshot(): HasOne
    {
        return $this->hasOne(InvoicePricingSnapshot::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function acknowledgments(): HasMany
    {
        return $this->hasMany(Acknowledgment::class);
    }
}