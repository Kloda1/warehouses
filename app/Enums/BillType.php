<?php
 
namespace App\Enums;

enum BillType: string
{
    case PURCHASE = 'purchase';
    // case SALE = 'sale';
    case TRANSFER = 'transfer';
    case ADJUSTMENT = 'adjustment';
    case RETURN = 'return';
    // case OPENING = 'opening';

    public function label(): string
    {
        return match($this) {
            self::PURCHASE => 'استلام', // شراء
            // self::SALE => 'بيع',
            self::TRANSFER => 'تسليم', //تحويل
            self::ADJUSTMENT => 'تركيب  وتنسيق', //تعديل
            self::RETURN => 'إدخال',// إرجاع
            // self::OPENING => 'رصيد افتتاحي',
        };
    }

    public function isIncoming(): bool
    {
        return in_array($this, [self::RETURN, self::PURCHASE ]);
    }

    public function isOutgoing(): bool
    {
        return in_array($this, [self::ADJUSTMENT, self::TRANSFER]);
    }
}