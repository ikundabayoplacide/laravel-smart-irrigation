<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);
        // $rab = Role::create(['name' => 'rab']);
        // $sedo = Role::create(['name' => 'sedo']);
        // $naeb = Role::create(['name' => 'naeb']);
        $cooperative_manager = Role::create(['name' => 'cooperative_manager']);
        // $sector_agronome = Role::create(['name' => 'sector_agronome']);
        // $district_agronome = Role::create(['name' => 'district_agronome']);
        $self_farmer = Role::create(['name' => 'self_farmer']);
        
        $admin->givePermissionTo([
            'create-user',
            'delete-user',
            'edit-user',
            'device-list',
            'device-create',
            'device-edit',
            'device-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ]);

        $cooperative_manager->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);

        // $sedo->givePermissionTo([
        //     'create-cooperative',
        //     'edit-cooperative',
        //     'delete-cooperative',
        // ]);
    }
}
