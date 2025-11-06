<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Dashboard
            [
                'name' => 'view_dashboard',
                'display_name' => 'لوحة التحكم',
                'description' => 'الوصول إلى لوحة التحكم الرئيسية',
                'route' => '/',
                'group' => 'dashboard'
            ],

            // Employee Positions
            [
                'name' => 'view_employee_positions',
                'display_name' => 'المناصب الوظيفية',
                'description' => 'عرض المناصب الوظيفية',
                'route' => 'employeepositions.index',
                'group' => 'positions'
            ],
            [
                'name' => 'manage_employee_positions',
                'display_name' => 'إدارة المناصب الوظيفية',
                'description' => 'إضافة وتعديل وحذف المناصب الوظيفية',
                'route' => 'employeepositions.*',
                'group' => 'positions'
            ],
            [
                'name' => 'manage_permissions',
                'display_name' => 'إدارة الصلاحيات',
                'description' => 'تعيين وإدارة صلاحيات المناصب الوظيفية',
                'route' => 'permissions.*',
                'group' => 'positions'
            ],

            // Statistics
            [
                'name' => 'view_statistics_dashboard',
                'display_name' => 'لوحة الإحصائيات',
                'description' => 'الوصول إلى لوحة الإحصائيات',
                'route' => 'stats.dashboard',
                'group' => 'statistics'
            ],
            [
                'name' => 'view_hierarchy',
                'display_name' => 'الهيكل التنظيمي',
                'description' => 'عرض الهيكل التنظيمي',
                'route' => 'stats.hierarchy',
                'group' => 'statistics'
            ],
            [
                'name' => 'view_monthly_statistics',
                'display_name' => 'احصائياتي الشهرية',
                'description' => 'عرض الإحصائيات الشهرية',
                'route' => 'subtask-analyst',
                'group' => 'statistics'
            ],
            [
                'name' => 'view_yearly_statistics',
                'display_name' => 'احصائياتي السنوية',
                'description' => 'عرض الإحصائيات السنوية',
                'route' => 'subtask-analyst',
                'group' => 'statistics'
            ],

            // Strategy Employee Approval
            [
                'name' => 'strategy_employee_approval',
                'display_name' => 'الموافقة كموظف استراتيجية',
                'description' => 'الموافقة على المهام كموظف استراتيجية',
                'route' => 'subtask.strategyEmployeeApproval',
                'group' => 'strategy'
            ],

            // Team Management
            [
                'name' => 'view_my_team',
                'display_name' => 'فريقي',
                'description' => 'عرض أعضاء الفريق',
                'route' => 'employeepositions/team/*',
                'group' => 'team'
            ],
            [
                'name' => 'view_top_employees',
                'display_name' => 'أعلى الموظفين أداء',
                'description' => 'عرض أعلى الموظفين أداءً',
                'route' => 'employeepositionstop',
                'group' => 'team'
            ],

            // Strategic Goals & Indicators
            [
                'name' => 'view_strategic_goals',
                'display_name' => 'الأهداف الإستراتيجية',
                'description' => 'عرض الأهداف الإستراتيجية',
                'route' => 'hadafstrategies',
                'group' => 'strategy'
            ],
            [
                'name' => 'manage_strategic_goals',
                'display_name' => 'إدارة الأهداف الإستراتيجية',
                'description' => 'إضافة وتعديل وحذف الأهداف الإستراتيجية',
                'route' => 'hadafstrategies.*',
                'group' => 'strategy'
            ],
            [
                'name' => 'view_strategic_indicators',
                'display_name' => 'المؤشرات الإستراتيجية',
                'description' => 'عرض المؤشرات الإستراتيجية',
                'route' => 'moasheradastrategy',
                'group' => 'strategy'
            ],
            [
                'name' => 'manage_strategic_indicators',
                'display_name' => 'إدارة المؤشرات الإستراتيجية',
                'description' => 'إضافة وتعديل وحذف المؤشرات الإستراتيجية',
                'route' => 'moasheradastrategy.*',
                'group' => 'strategy'
            ],
            [
                'name' => 'view_initiatives',
                'display_name' => 'المبادرات',
                'description' => 'عرض المبادرات',
                'route' => 'mubadara',
                'group' => 'strategy'
            ],
            [
                'name' => 'manage_initiatives',
                'display_name' => 'إدارة المبادرات',
                'description' => 'إضافة وتعديل وحذف المبادرات',
                'route' => 'mubadara.*',
                'group' => 'strategy'
            ],
            [
                'name' => 'view_efficiency_indicators',
                'display_name' => 'مؤشرات الكفاءة والفعالية',
                'description' => 'عرض مؤشرات الكفاءة والفعالية',
                'route' => 'moashermkmf',
                'group' => 'strategy'
            ],
            [
                'name' => 'manage_efficiency_indicators',
                'display_name' => 'إدارة مؤشرات الكفاءة والفعالية',
                'description' => 'إضافة وتعديل وحذف مؤشرات الكفاءة والفعالية',
                'route' => 'moashermkmf.*',
                'group' => 'strategy'
            ],
            [
                'name' => 'view_main_tasks',
                'display_name' => 'الإجراءات الرئيسية',
                'description' => 'عرض الإجراءات الرئيسية',
                'route' => 'task',
                'group' => 'tasks'
            ],
            [
                'name' => 'manage_main_tasks',
                'display_name' => 'إدارة الإجراءات الرئيسية',
                'description' => 'إضافة وتعديل وحذف الإجراءات الرئيسية',
                'route' => 'task.*',
                'group' => 'tasks'
            ],
            [
                'name' => 'view_subtasks',
                'display_name' => 'المهام الفرعية',
                'description' => 'عرض المهام الفرعية',
                'route' => 'subtask',
                'group' => 'tasks'
            ],
            [
                'name' => 'manage_subtasks',
                'display_name' => 'إدارة المهام الفرعية',
                'description' => 'إضافة وتعديل وحذف المهام الفرعية',
                'route' => 'subtask.*',
                'group' => 'tasks'
            ],

            // Tasks Section
            [
                'name' => 'assign_to_team',
                'display_name' => 'إسناد لفريقي',
                'description' => 'إسناد المهام لأعضاء الفريق',
                'route' => 'settomyteam',
                'group' => 'tasks'
            ],
            [
                'name' => 'view_assignment_stats',
                'display_name' => 'إحصائيات الإسناد',
                'description' => 'عرض إحصائيات الإسناد',
                'route' => 'subtask.assignmentStats',
                'group' => 'tasks'
            ],
            [
                'name' => 'approve_tasks',
                'display_name' => 'الموافقة على المهام',
                'description' => 'الموافقة على المهام المنجزة',
                'route' => 'subtaskapproval',
                'group' => 'tasks'
            ],
            [
                'name' => 'view_my_tasks',
                'display_name' => 'مهامي',
                'description' => 'عرض مهامي الشخصية',
                'route' => 'mysubtasks',
                'group' => 'tasks'
            ],
            [
                'name' => 'view_overdue_tasks',
                'display_name' => 'المهام المتأخرة',
                'description' => 'عرض المهام المتأخرة',
                'route' => 'subtask.overdue',
                'group' => 'tasks'
            ],

            // Tickets
            [
                'name' => 'view_tickets',
                'display_name' => 'التذاكر',
                'description' => 'عرض التذاكر',
                'route' => 'tickets',
                'group' => 'tickets'
            ],
            [
                'name' => 'create_tickets',
                'display_name' => 'أضف تذكرة جديدة',
                'description' => 'إضافة تذاكر جديدة',
                'route' => 'tickets/create',
                'group' => 'tickets'
            ],
            [
                'name' => 'manage_all_tickets',
                'display_name' => 'إدارة جميع التذاكر',
                'description' => 'إدارة جميع التذاكر (للمسؤولين)',
                'route' => 'tickets.admin.index',
                'group' => 'tickets'
            ],

            // Calendar
            [
                'name' => 'view_calendar',
                'display_name' => 'التقويم',
                'description' => 'عرض التقويم',
                'route' => 'mysubtaskscalendar',
                'group' => 'calendar'
            ],

            // Password
            [
                'name' => 'change_password',
                'display_name' => 'تغيير كلمة المرور',
                'description' => 'تغيير كلمة المرور الشخصية',
                'route' => 'password.change',
                'group' => 'profile'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
