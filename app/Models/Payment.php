<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'payment_reference',
        'gateway',
        'amount',
        'currency',
        'status',
        'payment_channel',
        'proof_of_payment_path',
        'gateway_response',
        'paid_at',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isPaystack(): bool
    {
        return $this->gateway === 'paystack';
    }

    public function isManualTransfer(): bool
    {
        return $this->payment_channel === 'bank_transfer'
            || $this->payment_channel === 'manual_transfer';
    }
}