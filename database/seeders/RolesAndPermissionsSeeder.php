<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage roles']);

        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        // Role::create(['name' => 'rab', 'guard_name' => 'web']);
        // Role::create(['name' => 'sedo', 'guard_name' => 'web']);
        // Role::create(['name'=> 'naeb', 'guard_name' => 'web']);
        
        
        Role::create(['name' => 'cooperative_manager', 'guard_name' => 'web']);
        // Role::create(['name'=> 'sector_agronome', 'guard_name' => 'web']);
        // Role::create(['name'=> 'district_agronome', 'guard_name' => 'web']);
        Role::create(['name'=> 'self-farmer', 'guard_name' => 'web']);
    }
}
