<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BatchWindow extends Model
{
    protected $fillable = [
        'name',
        'cutoff_time',
        'fulfillment_start_time',
        'fulfillment_end_time',
        'timezone',
        'capacity_limit',
        'status',
    ];

    public function conciergeRequests(): HasMany
    {
        return $this->hasMany(ConciergeRequest::class);
    }
}