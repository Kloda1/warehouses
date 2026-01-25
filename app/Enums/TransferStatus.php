<?php
 

namespace App\Enums;

enum TransferStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case IN_TRANSIT = 'in_transit';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'معلق',
            self::APPROVED => 'معتمد',
            self::IN_TRANSIT => 'قيد النقل',
            self::COMPLETED => 'مكتمل',
            self::CANCELLED => 'ملغي',
        };
    }
}