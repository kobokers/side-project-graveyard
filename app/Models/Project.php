<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'domain',
        'asking_price',
        'category',
        'story',
        'tech_stack',
        'monthly_traffic',
        'total_revenue',
        'status',
        'is_featured',
        'featured_until',
        'images',
        'contact_email',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
        'asking_price' => 'integer',
        'total_revenue' => 'integer',
        'monthly_traffic' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function activePurchase()
    {
        return $this->hasOne(Purchase::class)->whereIn('status', ['pending', 'escrowed', 'in_transfer']);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return $this->asking_price > 0 ? '$' . number_format($this->asking_price / 100, 2) : 'Free';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('featured_until', '>', now());
    }

    public function scopeAvailableForPurchase($query)
    {
        return $query->where('status', 'active')
                     ->whereNull('buyer_id');
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isSold()
    {
        return $this->buyer_id !== null || $this->status === 'sold';
    }

    public function isAvailableForPurchase()
    {
        return $this->status === 'active' && !$this->isSold();
    }
}
