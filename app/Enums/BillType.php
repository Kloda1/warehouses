<?php
 
namespace App\Enums;

enum BillType: string
{
    case PURCHASE = 'purchase';
    case SALE = 'sale';
    case TRANSFER = 'transfer';
    case ADJUSTMENT = 'adjustment';
    case RETURN = 'return';
    case OPENING = 'opening';

    public function label(): string
    {
        return match($this) {
            self::PURCHASE => 'شراء',
            self::SALE => 'بيع',
            self::TRANSFER => 'تحويل',
            self::ADJUSTMENT => 'تعديل',
            self::RETURN => 'إرجاع',
            self::OPENING => 'رصيد افتتاحي',
        };
    }

    public function isIncoming(): bool
    {
        return in_array($this, [self::PURCHASE, self::RETURN, self::OPENING]);
    }

    public function isOutgoing(): bool
    {
        return in_array($this, [self::SALE, self::TRANSFER]);
    }
}