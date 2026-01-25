<?php
  

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createWarehouseKeeper(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => UserRole::WAREHOUSE_KEEPER,  
            'primary_warehouse_id' => $request->warehouse_id,
        ]);

 
        $user->assignRole(UserRole::WAREHOUSE_KEEPER->label());

        return response()->json(['message' => 'تم إنشاء أمين المخزن']);
    }

    public function checkPermission(User $user, $permission)
    {
 
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

      
        return $user->hasPermissionTo($permission);
    }
}