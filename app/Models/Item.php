<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'category_id',
        'unit',
        'purchase_price',
        'sale_price',
        'wholesale_price',
        'minimum_quantity',
        'opening_balance',
        'current_quantity',
        'reserved_quantity',
        'barcode',
        'is_active',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'minimum_quantity' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'current_quantity' => 'decimal:2',
        'reserved_quantity' => 'decimal:2',
    ];

   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

 
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

 
    public function updater()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }
 
 
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

     public function scopeNeedReorder($query)
    {
        return $query->whereRaw('current_quantity <= minimum_quantity');
    }

     public function scopeAvailable($query)
    {
        return $query->where('current_quantity', '>', 0);
    }

     public function scopeOutOfStock($query)
    {
        return $query->where('current_quantity', '<=', 0);
    }

     public function getAvailableQuantityAttribute()
    {
        return max(0, $this->current_quantity - $this->reserved_quantity);
    }

     public function getNeedsReorderAttribute()
    {
        return $this->current_quantity <= $this->minimum_quantity;
    }

  
    public function getTotalValueAttribute()
    {
        return $this->current_quantity * $this->purchase_price;
    }

   
    public function getProfitMarginAttribute()
    {
        if ($this->purchase_price == 0) return 0;
        return (($this->sale_price - $this->purchase_price) / $this->purchase_price) * 100;
    }
 
    public function getStockStatusAttribute()
    {
        if ($this->current_quantity <= 0) {
            return ['label' => 'منتهي', 'color' => 'danger'];
        } elseif ($this->needs_reorder) {
            return ['label' => 'يحتاج طلب', 'color' => 'warning'];
        } elseif ($this->available_quantity < $this->minimum_quantity) {
            return ['label' => 'منخفض', 'color' => 'info'];
        } else {
            return ['label' => 'متوفر', 'color' => 'success'];
        }
    }
}