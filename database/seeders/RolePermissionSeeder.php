<?php
 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Enums\UserRole;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         foreach (UserRole::cases() as $roleEnum) {
            Role::firstOrCreate([
                'name' => $roleEnum->label(),
            ], [
                'guard_name' => 'web',
                'description' => 'دور ' . $roleEnum->label(),
            ]);
        }

         $permissions = [
             'view_dashboard',
            
             'view_users', 'create_users', 'edit_users', 'delete_users',
            'assign_roles', 'manage_roles', 'manage_permissions',
            
         
            'view_items', 'create_items', 'edit_items', 'delete_items',
            'import_items', 'export_items',
            
         
            'view_warehouses', 'create_warehouses', 'edit_warehouses', 'delete_warehouses',
            
       
            'view_bills', 'create_bills', 'edit_bills', 'delete_bills',
            'approve_bills', 'cancel_bills', 'print_bills',
            
       
            'view_transfers', 'create_transfers', 'edit_transfers',
            'approve_transfers', 'receive_transfers',
            
          
            'view_reports', 'generate_reports', 'export_reports',
            
       
            'view_customers', 'create_customers', 'edit_customers', 'delete_customers',
            
             'view_suppliers', 'create_suppliers', 'edit_suppliers', 'delete_suppliers',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

         foreach (UserRole::cases() as $roleEnum) {
            $role = Role::where('name', $roleEnum->label())->first();
            if ($role) {
                $role->syncPermissions($roleEnum->permissions());
            }
        }

         $this->createUsers();
 
    }

    private function createUsers(): void
    {
     
        $admin = User::create([
            'username' => 'admin',
            'name' => 'مدير النظام',
            'email' => 'admin@system.com',
            'password' => bcrypt('admin123'),
            'role' => UserRole::ADMIN,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $admin->assignRole(UserRole::ADMIN->label()); 

       
        $keeper = User::create([
            'username' => 'keeper',
            'name' => 'أمين المخزن',
            'email' => 'keeper@system.com',
            'password' => bcrypt('keeper123'),
            'role' => UserRole::WAREHOUSE_KEEPER,
            'is_active' => true,
            'email_verified_at' => now(),
            'primary_warehouse_id' => 1, 
        ]);

        $keeper->assignRole(UserRole::WAREHOUSE_KEEPER->label());

        
        $accountant = User::create([
            'username' => 'accountant',
            'name' => 'محاسب النظام',
            'email' => 'accountant@system.com',
            'password' => bcrypt('accountant123'),
            'role' => UserRole::ACCOUNTANT,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $accountant->assignRole(UserRole::ACCOUNTANT->label());

 
        $viewer = User::create([
            'username' => 'viewer',
            'name' => 'مستخدم للمشاهدة',
            'email' => 'viewer@system.com',
            'password' => bcrypt('viewer123'),
            'role' => UserRole::VIEWER,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $viewer->assignRole(UserRole::VIEWER->label());
    }
}