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

     public function color(): string
    {
        return match($this) {
            self::CENTRAL => 'danger',
            self::BRANCH => 'success',
            self::STORE => 'info',
            self::TEMPORARY => 'warning',
            self::VIRTUAL => 'gray',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::CENTRAL => 'heroicon-o-building-library',
            self::BRANCH => 'heroicon-o-building-office',
            self::STORE => 'heroicon-o-building-storefront',
            self::TEMPORARY => 'heroicon-o-clock',
            self::VIRTUAL => 'heroicon-o-cloud',
        };
    }
}