<?php
 

namespace App\Enums;

enum UserRole: string
{
   

      case ADMIN = 'admin';
    case MONITOR = 'manager';
    case WAREHOUSE_KEEPER = 'warehouse_keeper';
 

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'مدير النظام',
            self::MONITOR => 'مراقب',
            self::WAREHOUSE_KEEPER => 'أمين مخزن',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ADMIN => 'danger',
            self::MONITOR => 'success',
            self::WAREHOUSE_KEEPER => 'info',
 
        };
    }
}