<?php
 
namespace App\Enums;
 
enum BillStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case RETURNED = 'returned';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'مسودة',
            self::PENDING => 'قيد الانتظار',
            self::APPROVED => 'معتمد',
            self::COMPLETED => 'مكتمل',
            self::CANCELLED => 'ملغي',
            self::RETURNED => 'مرتجع',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PENDING => 'warning',
            self::APPROVED => 'info',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
            self::RETURNED => 'orange',
        };
    }

    public function isEditable(): bool
    {
        return in_array($this, [self::DRAFT, self::PENDING]);
    }
}