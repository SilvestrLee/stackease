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

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isUnpaid(): bool
    {
        return ! $this->isPaid();
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && now()->greaterThan($this->expires_at);
    }

    public function isPayable(): bool
    {
        return in_array($this->status, [
            'sent',
            'awaiting_payment',
            'expired',
        ], true);
    }

    public function isUnderpaid(): bool
    {
        return $this->status === 'underpaid_action_required';
    }

    public function isExpiredPaidFlagged(): bool
    {
        return $this->status === 'expired_paid_flagged';
    }

    public function formattedTotal(): string
    {
        return '₦' . number_format((float) $this->total_naira_amount, 2);
    }
}