<?php
 

namespace App\Enums;

enum InventoryLogType: string
{
    case PURCHASE = 'purchase';
    case SALE = 'sale';
    case TRANSFER_IN = 'transfer_in';
    case TRANSFER_OUT = 'transfer_out';
    case ADJUSTMENT = 'adjustment';
    case RETURN_IN = 'return_in';
    case RETURN_OUT = 'return_out';
    case OPENING = 'opening';
    case CORRECTION = 'correction';

    public function label(): string
    {
        return match($this) {
            self::PURCHASE => 'شراء',
            self::SALE => 'بيع',
            self::TRANSFER_IN => 'تحويل وارد',
            self::TRANSFER_OUT => 'تحويل صادر',
            self::ADJUSTMENT => 'تعديل',
            self::RETURN_IN => 'إرجاع وارد',
            self::RETURN_OUT => 'إرجاع صادر',
            self::OPENING => 'رصيد افتتاحي',
            self::CORRECTION => 'تصحيح',
        };
    }

    public function isIncoming(): bool
    {
        return in_array($this, [
            self::PURCHASE,
            self::TRANSFER_IN,
            self::RETURN_IN,
            self::OPENING,
        ]);
    }

    public function isOutgoing(): bool
    {
        return in_array($this, [
            self::SALE,
            self::TRANSFER_OUT,
            self::RETURN_OUT,
        ]);
    }
}