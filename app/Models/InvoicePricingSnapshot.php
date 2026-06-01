<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePricingSnapshot extends Model
{
    protected $fillable = [
        'invoice_id',
        'provider_cost_amount',
        'provider_cost_currency',
        'fx_rate',
        'local_provider_cost',
        'fx_buffer_percent',
        'fx_buffer_amount',
        'service_fee',
        'gateway_fee',
        'final_total',
        'rate_source',
        'valid_until',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'provider_cost_amount' => 'decimal:2',
            'fx_rate' => 'decimal:2',
            'local_provider_cost' => 'decimal:2',
            'fx_buffer_percent' => 'decimal:2',
            'fx_buffer_amount' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'gateway_fee' => 'decimal:2',
            'final_total' => 'decimal:2',
            'valid_until' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}