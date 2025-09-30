<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
 public function run(): void
    {
        $modules = [
            'users',
            'units',
            'departments',
            'location',
            'grades',
            'jobs',
            'position',
            'hr',
            'booking', // ضفت booking
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        $permissions = [];

        // إنشاء الصلاحيات لكل Module بالصيغة الجديدة "action module"
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = "$action $module";
            }
        }

        // حفظ الصلاحيات في DB
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // ============ Roles ============

        // 1- Admin: كل الصلاحيات
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 2- HR: صلاحيات hr بالكامل + عرض باقي الجداول
        $hrRole = Role::firstOrCreate(['name' => 'hr', 'guard_name' => 'web']);
        $hrPermissions = Permission::where('name', 'like', 'hr.%')
            ->orWhere('name', 'like', 'view%')
            ->get();
        $hrRole->syncPermissions($hrPermissions);

        // 3- User: عرض فقط
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userPermissions = Permission::where('name', 'like', 'view%')->get();
        $userRole->syncPermissions($userPermissions);
    }
}
