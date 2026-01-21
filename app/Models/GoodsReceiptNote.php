<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNote extends Model
{
        protected $fillable = [
        'memo_number',
        'order_number',
        'folder_number',
        'bill_number',
        'date',
        'financial_memo_number',
        'bill_date',
        'order_date',
        'description',
        'deliver'
    ];
        protected static function booted()
    {
        static::creating(function ($memo) {
            if (empty($memo->memo_number)) {
                $lastNumber = self::max('memo_number') ?? 0;
                $memo->memo_number = $lastNumber + 1;
            }
        });
    }
        
}
