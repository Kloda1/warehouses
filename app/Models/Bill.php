<?php
 

namespace App\Models;

use App\Enums\BillStatus;
use App\Enums\BillType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    protected $fillable = [
        'bill_number',
        'date',
        'type',
        'status',
        'supplier_id',
        'customer_id',
        'party_name',
        'source_warehouse_id',
        'destination_warehouse_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'reference_number',
        'reference_date',
        'notes',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'date' => 'date',
        'reference_date' => 'date',
        'approved_at' => 'datetime',
        'type' => BillType::class,
        'status' => BillStatus::class,
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];
      
    public function records() : HasMany
    {
        return $this->hasMany(BillRecords::class);
    }

      
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function sourceWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'source_warehouse_id');
    }

    public function destinationWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

 
    public function scopePurchase($query)
    {
        return $query->where('type', BillType::PURCHASE);
    }

    public function scopeSale($query)
    {
        return $query->where('type', BillType::SALE);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', BillStatus::DRAFT);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', BillStatus::COMPLETED);
    }

     public function isEditable(): bool
    {
        return $this->status->isEditable();
    }

    public function isPurchase(): bool
    {
        return $this->type === BillType::PURCHASE;
    }

    public function isSale(): bool
    {
        return $this->type === BillType::SALE;
    }
}