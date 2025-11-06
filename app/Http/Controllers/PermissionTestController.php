<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\EmployeePosition;

class PermissionTestController extends Controller
{
    /**
     * Show permissions test page
     */
    public function index()
    {
        $userPosition = current_user_position();
        $allPermissions = Permission::all();
        $userPermissions = $userPosition ? $userPosition->permissions : collect();
        
        return view('permission-test', [
            'userPosition' => $userPosition,
            'allPermissions' => $allPermissions,
            'userPermissions' => $userPermissions,
        ]);
    }
    
    /**
     * Test a specific permission
     */
    public function test($permission)
    {
        if (has_permission($permission)) {
            return response()->json([
                'success' => true,
                'message' => "You have the '{$permission}' permission!",
                'user_position' => current_user_position()->name ?? 'Unknown'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have the '{$permission}' permission.",
                'user_position' => current_user_position()->name ?? 'Unknown'
            ], 403);
        }
    }
}