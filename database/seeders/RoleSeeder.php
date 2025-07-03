<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $user = User::find(1); // ou email
        $user->assignRole('SuperAdmin');
    }
}
