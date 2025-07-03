<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_admin::adresse","view_any_admin::adresse","create_admin::adresse","update_admin::adresse","restore_admin::adresse","restore_any_admin::adresse","replicate_admin::adresse","reorder_admin::adresse","delete_admin::adresse","delete_any_admin::adresse","force_delete_admin::adresse","force_delete_any_admin::adresse","view_admin::category","view_any_admin::category","create_admin::category","update_admin::category","restore_admin::category","restore_any_admin::category","replicate_admin::category","reorder_admin::category","delete_admin::category","delete_any_admin::category","force_delete_admin::category","force_delete_any_admin::category","view_admin::coupon","view_any_admin::coupon","create_admin::coupon","update_admin::coupon","restore_admin::coupon","restore_any_admin::coupon","replicate_admin::coupon","reorder_admin::coupon","delete_admin::coupon","delete_any_admin::coupon","force_delete_admin::coupon","force_delete_any_admin::coupon","view_admin::depense","view_any_admin::depense","create_admin::depense","update_admin::depense","restore_admin::depense","restore_any_admin::depense","replicate_admin::depense","reorder_admin::depense","delete_admin::depense","delete_any_admin::depense","force_delete_admin::depense","force_delete_any_admin::depense","view_admin::employee","view_any_admin::employee","create_admin::employee","update_admin::employee","restore_admin::employee","restore_any_admin::employee","replicate_admin::employee","reorder_admin::employee","delete_admin::employee","delete_any_admin::employee","force_delete_admin::employee","force_delete_any_admin::employee","view_admin::horaire","view_any_admin::horaire","create_admin::horaire","update_admin::horaire","restore_admin::horaire","restore_any_admin::horaire","replicate_admin::horaire","reorder_admin::horaire","delete_admin::horaire","delete_any_admin::horaire","force_delete_admin::horaire","force_delete_any_admin::horaire","view_admin::order","view_any_admin::order","create_admin::order","update_admin::order","restore_admin::order","restore_any_admin::order","replicate_admin::order","reorder_admin::order","delete_admin::order","delete_any_admin::order","force_delete_admin::order","force_delete_any_admin::order","view_admin::product","view_any_admin::product","create_admin::product","update_admin::product","restore_admin::product","restore_any_admin::product","replicate_admin::product","reorder_admin::product","delete_admin::product","delete_any_admin::product","force_delete_admin::product","force_delete_any_admin::product","view_admin::reservation","view_any_admin::reservation","create_admin::reservation","update_admin::reservation","restore_admin::reservation","restore_any_admin::reservation","replicate_admin::reservation","reorder_admin::reservation","delete_admin::reservation","delete_any_admin::reservation","force_delete_admin::reservation","force_delete_any_admin::reservation","view_admin::restaurant::table","view_any_admin::restaurant::table","create_admin::restaurant::table","update_admin::restaurant::table","restore_admin::restaurant::table","restore_any_admin::restaurant::table","replicate_admin::restaurant::table","reorder_admin::restaurant::table","delete_admin::restaurant::table","delete_any_admin::restaurant::table","force_delete_admin::restaurant::table","force_delete_any_admin::restaurant::table","view_admin::slider","view_any_admin::slider","create_admin::slider","update_admin::slider","restore_admin::slider","restore_any_admin::slider","replicate_admin::slider","reorder_admin::slider","delete_admin::slider","delete_any_admin::slider","force_delete_admin::slider","force_delete_any_admin::slider","view_admin::user","view_any_admin::user","create_admin::user","update_admin::user","restore_admin::user","restore_any_admin::user","replicate_admin::user","reorder_admin::user","delete_admin::user","delete_any_admin::user","force_delete_admin::user","force_delete_any_admin::user","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","page_Notifications","page_Parametre","page_Statistiques","widget_EmployeesStat","widget_MostOrderedDishes","widget_OrdersChart","widget_RecentOrders","widget_ReservationsChart","widget_StatsCaisse","widget_StatsClient"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
