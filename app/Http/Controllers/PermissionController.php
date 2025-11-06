<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\EmployeePosition;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display permissions management page
     */
    public function index()
    {
        $employeePositions = EmployeePosition::with('permissions')->get();
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get();
        
        $groupedPermissions = $permissions->groupBy('group');
        
        return view('permissions.index', compact('employeePositions', 'groupedPermissions'));
    }

    /**
     * Show form to create new permission
     */
    public function create()
    {
        $groups = [
            'dashboard' => 'لوحة التحكم',
            'positions' => 'المناصب والصلاحيات',
            'statistics' => 'الإحصائيات',
            'strategy' => 'الأهداف الإستراتيجية',
            'team' => 'إدارة الفريق',
            'tasks' => 'المهام',
            'tickets' => 'التذاكر',
            'calendar' => 'التقويم',
            'profile' => 'الملف الشخصي',
            'reports' => 'التقارير',
            'settings' => 'الإعدادات',
            'general' => 'عام'
        ];
        
        return view('permissions.create', compact('groups'));
    }

    /**
     * Store new permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'group' => 'required|string|max:50',
            'route' => 'nullable|string|max:255'
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'group' => $request->group,
            'route' => $request->route
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الصلاحية بنجاح',
            'permission' => $permission
        ]);
    }

    /**
     * Show form to edit permission
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        
        $groups = [
            'dashboard' => 'لوحة التحكم',
            'positions' => 'المناصب والصلاحيات',
            'statistics' => 'الإحصائيات',
            'strategy' => 'الأهداف الإستراتيجية',
            'team' => 'إدارة الفريق',
            'tasks' => 'المهام',
            'tickets' => 'التذاكر',
            'calendar' => 'التقويم',
            'profile' => 'الملف الشخصي',
            'reports' => 'التقارير',
            'settings' => 'الإعدادات',
            'general' => 'عام'
        ];
        
        return view('permissions.edit', compact('permission', 'groups'));
    }

    /**
     * Update permission
     */
    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'group' => 'required|string|max:50',
            'route' => 'nullable|string|max:255'
        ]);

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'group' => $request->group,
            'route' => $request->route
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الصلاحية بنجاح',
            'permission' => $permission
        ]);
    }

    /**
     * Delete permission
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        
        // Check if permission is assigned to any positions
        $assignedCount = $permission->employeePositions()->count();
        
        if ($assignedCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "لا يمكن حذف هذه الصلاحية لأنها مخصصة لـ {$assignedCount} منصب وظيفي"
            ], 400);
        }

        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الصلاحية بنجاح'
        ]);
    }

    /**
     * Update permissions for an employee position
     */
    public function update(Request $request, $positionId)
    {
        $position = EmployeePosition::findOrFail($positionId);
        
        $permissions = $request->input('permissions', []);
        
        // Sync permissions (this will attach new ones and detach removed ones)
        $position->permissions()->sync($permissions);
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الصلاحيات بنجاح'
        ]);
    }

    /**
     * Get permissions for a specific employee position
     */
    public function getPermissions($positionId)
    {
        $position = EmployeePosition::with('permissions')->findOrFail($positionId);
        
        return response()->json([
            'success' => true,
            'permissions' => $position->permissions->pluck('id')
        ]);
    }

    /**
     * Get all permissions as JSON (for API)
     */
    public function getAllPermissions()
    {
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get();
        $grouped = $permissions->groupBy('group');
        
        return response()->json([
            'success' => true,
            'permissions' => $permissions,
            'grouped' => $grouped
        ]);
    }
}
