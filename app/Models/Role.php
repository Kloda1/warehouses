<?php
 

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Enums\UserRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

     public static function syncWithEnum()
    {
        foreach (UserRole::cases() as $roleEnum) {
            self::firstOrCreate([
                'name' => $roleEnum->label(),
            ], [
                'guard_name' => 'web',
                'description' => 'دور ' . $roleEnum->label(),
            ]);
        }
    }

     public static function fromEnum(UserRole $enum)
    {
        return self::where('name', $enum->label())->first();
    }
}