<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'super-admin'
            ], [
                'name' => 'admin', 'permissions' => [
                    ['user', 'action' => ['view', 'add', 'update', 'delete', 'activate', 'deactivate']],
                    ['role', 'action' => ['view', 'add', 'update', 'delete', 'activate', 'deactivate', 'grant-permission']],
                    ['block', 'action' => ['view', 'add', 'update', 'delete']],
                    ['side', 'action' => ['view', 'add', 'update', 'delete']],
                    ['room', 'action' => ['view', 'add', 'update', 'delete']],
                    ['student', 'action' => ['view', 'add', 'update','remove-allocation', 'allocation', 'delete']],
                ]
            ], [
                'name' => 'dean', 'permissions' => [
                    ['student', 'action' => ['view', 'add', 'update','remove-allocation', 'allocation', 'delete']],
                    ['block', 'action' => ['view', 'add', 'update', 'delete']],
                    ['side', 'action' => ['view', 'add', 'update', 'delete']],
                    ['room', 'action' => ['view', 'add', 'update', 'delete']],
                    ['application', 'action' => ['view', 'decline', 'accept', 'update']],
                    ['invoice', 'action' => ['view', 'create', 'delete']],
                    ['shortlist', 'action' => ['view', 'create', 'delete', 'publish']],
                    ['deadline', 'action' => ['view', 'add', 'update']],
                ]
            ], [
                'permissions' => [
                    // ['personal-information', 'action' => ['update', 'create', 'complete']],
                ]
            ]
        ];


        foreach ($roles as $role) {
            if (isset($role['name'])) { // if role is found create it
                $roleInstance = Role::firstOrCreate([
                    'name' => $role['name']
                ]);
                echo "Role $roleInstance->name  created \n";
            }

            foreach ($role['permissions']??[] as $permission) {
                foreach ($permission['action'] as $action) {
                    $permissionInstance = Permission::firstOrCreate(['name' => $permission[0].'-'.$action]);
                    echo "Permission $permissionInstance->name  created \n";
                    if (isset($role['name'])) { // if role was created give permissions to that role
                        $roleInstance->givePermissionTo($permissionInstance->name);
                    }
                }
            }
        }
    }
}
