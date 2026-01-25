<?php
 

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case WAREHOUSE_KEEPER = 'warehouse_keeper';
    case ACCOUNTANT = 'accountant';
    case VIEWER = 'viewer';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'مدير النظام',
            self::MANAGER => 'مدير',
            self::WAREHOUSE_KEEPER => 'أمين مخزن',
            self::ACCOUNTANT => 'محاسب',
            self::VIEWER => 'مشاهد',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ADMIN => 'danger',
            self::MANAGER => 'success',
            self::WAREHOUSE_KEEPER => 'info',
            self::ACCOUNTANT => 'warning',
            self::VIEWER => 'gray',
        };
    }

    public function permissions(): array
    {
        return match($this) {
            self::ADMIN => Permission::all()->pluck('name')->toArray(),
            self::MANAGER => [
                'view_dashboard',
                'view_items', 'create_items', 'edit_items',
                'view_warehouses',
                'view_bills', 'create_bills', 'edit_bills', 'approve_bills',
                'view_transfers', 'create_transfers', 'approve_transfers',
                'view_reports',
                'view_customers', 'create_customers', 'edit_customers',
                'view_suppliers', 'create_suppliers', 'edit_suppliers',
            ],
            self::WAREHOUSE_KEEPER => [
                'view_dashboard',
                'view_items', 'create_items', 'edit_items',
                'view_warehouses',
                'view_bills', 'create_bills', 'edit_bills',
                'view_transfers', 'create_transfers', 'receive_transfers',
                'view_customers',
                'view_suppliers',
            ],
            self::ACCOUNTANT => [
                'view_dashboard',
                'view_items',
                'view_warehouses',
                'view_bills', 'create_bills', 'edit_bills', 'approve_bills',
                'view_reports',
                'view_customers', 'create_customers', 'edit_customers',
                'view_suppliers', 'create_suppliers', 'edit_suppliers',
            ],
            self::VIEWER => [
                'view_dashboard',
                'view_items',
                'view_warehouses',
                'view_bills',
                'view_reports',
                'view_customers',
                'view_suppliers',
            ],
        };
    }
}