<?php



namespace App\Enums;

enum WarehouseType: string
{
    case CENTRAL = 'central';
    case BRANCH = 'branch';
    case STORE = 'store';
    case TEMPORARY = 'temporary';

    public function label(): string
    {
        return match($this) {
            self::CENTRAL => 'مركزي',
            self::BRANCH => 'فرعي',
            self::STORE => 'مخزن',
            self::TEMPORARY => 'مؤقت',
        };
    }
}