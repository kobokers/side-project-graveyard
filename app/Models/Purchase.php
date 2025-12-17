<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'project_id',
        'amount_paid',
        'seller_amount',
        'commission_amount',
        'status',
        'stripe_payment_intent_id',
        'stripe_transfer_id',
        'transfer_notes',
        'transfer_files',
        'escrowed_at',
        'transfer_started_at',
        'buyer_confirmed_at',
        'seller_paid_at',
        'disputed_at',
        'dispute_reason',
    ];

    protected $casts = [
        'transfer_files' => 'array',
        'escrowed_at' => 'datetime',
        'transfer_started_at' => 'datetime',
        'buyer_confirmed_at' => 'datetime',
        'seller_paid_at' => 'datetime',
        'disputed_at' => 'datetime',
    ];

    // Relationships
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Helper methods
    public function getFormattedAmountPaidAttribute()
    {
        return '$' . number_format($this->amount_paid / 100, 2);
    }

    public function getFormattedSellerAmountAttribute()
    {
        return '$' . number_format($this->seller_amount / 100, 2);
    }

    public function getFormattedCommissionAttribute()
    {
        return '$' . number_format($this->commission_amount / 100, 2);
    }

    public function canBeConfirmedByBuyer()
    {
        return in_array($this->status, ['escrowed', 'in_transfer']);
    }

    public function canBeDisputedByBuyer()
    {
        return in_array($this->status, ['escrowed', 'in_transfer']) && !$this->disputed_at;
    }

    public function isAwaitingTransfer()
    {
        return $this->status === 'escrowed';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeEscrowed($query)
    {
        return $query->where('status', 'escrowed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
