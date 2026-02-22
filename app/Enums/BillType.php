<?php
 
namespace App\Enums;

enum BillType: string
{
    case PURCHASE = 'purchase';
 
    case TRANSFER = 'transfer';
    case ADJUSTMENT = 'adjustment';
    case RETURN = 'return';
 
 
    public function label(): string
    {
        return match($this) {
            self::PURCHASE => 'استلام', 
           
            self::TRANSFER => 'تسليم', 
            self::ADJUSTMENT => 'تركيب  وتنسيق',  
            self::RETURN => 'إدخال', 
           
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