<?php
 
namespace App\Enums;

enum CustomerType: string
{
    case INDIVIDUAL = 'individual';
    case COMPANY = 'company';
    case GOVERNMENT = 'government';
    case WHOLESALER = 'wholesaler';
    case RETAILER = 'retailer';

    public function label(): string
    {
        return match($this) {
            self::INDIVIDUAL => 'فرد',
            self::COMPANY => 'شركة',
            self::GOVERNMENT => 'جهة حكومية',
            self::WHOLESALER => 'موزع',
            self::RETAILER => 'تاجر',
        };
    }
}