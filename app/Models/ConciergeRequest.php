<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConciergeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'batch_window_id',
        'request_reference',
        'service_name',
        'request_type',
        'desired_plan',
        'seat_count',
        'duration',
        'budget_range',
        'existing_account',
        'issue_description',
        'user_notes',
        'admin_notes',
        'status',
        'priority',
        'reviewed_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'existing_account' => 'boolean',
            'reviewed_at' => 'datetime',
            'completed_at' => 'datetime',
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

    public function batchWindow(): BelongsTo
    {
        return $this->belongsTo(BatchWindow::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }
}