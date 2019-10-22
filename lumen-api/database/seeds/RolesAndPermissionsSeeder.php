<?php

use Illuminate\Database\Seeder;
//use App\Models\Role;
//use App\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
//        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
//
//        config(['permission.models.role' => App\Models\Role::class]);
//        config(['permission.models.permission' => App\Models\Permission::class]);

        // create permissions
        $this->newPermissions();

        // create roles and assign created permissions
        $this->newRoles();
    }

    public function newPermissions()
    {
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'delete-users']);
    }

    public function newRoles()
    {
        // this can be done as separate statements
//        $role = Role::create(['name' => 'admin']);
//        $role->givePermissionTo(['manage-orders', 'edit-products']); //, 'delete-products'

        // create super admin and give all permissions
        $role = Role::create(['name' => 'super-admin']);
//        $role->givePermissionTo(Permission::where(['guard_name' => 'web'])->get());
        $role->givePermissionTo(Permission::all());
    }
}
