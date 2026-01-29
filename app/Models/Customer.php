<?php

namespace App\Models;

use App\Enums\CustomerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'type',
        'contact_person',
        'phone',
        'email', 
        'address',
        'tax_number', 
        'commercial_register',
        'total_sales',//
        'balance',
        'credit_limit',
        'total_orders', //
        'is_active',
        'notes',//
    ];

    protected $casts = [
        'type' => CustomerType::class,
        'is_active' => 'boolean',
        'total_sales' => 'decimal:2',
        'balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
    ];

     public function bills()
    {
        return $this->hasMany(Bill::class);
    }

     public function sales()
    {
        return $this->hasMany(Bill::class)->where('type', 'sale');
    }

     public function payments()
    {
        return $this->hasMany(Payment::class);
    }

     public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

     public function scopeHasBalance($query)
    {
        return $query->where('balance', '!=', 0);
    }

     public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

     public function getBalanceStatusAttribute()
    {
        if ($this->balance > 0) {
            return ['label' => 'مدين', 'color' => 'danger'];
        } elseif ($this->balance < 0) {
            return ['label' => 'دائن', 'color' => 'success'];
        } else {
            return ['label' => 'متوازن', 'color' => 'info'];
        }
    }

     public function getHasExceededCreditLimitAttribute()
    {
        return abs($this->balance) > $this->credit_limit;
    }
}