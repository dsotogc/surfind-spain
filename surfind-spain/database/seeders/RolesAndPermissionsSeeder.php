<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        foreach (Permissions::cases() as $permission) {
            Permission::create(['name' => $permission->value]);
        }

        $userRole = Role::create(['name' => Roles::USER->value]);
        $userRole->givePermissionTo([Permissions::VIEW_BEACHES->value,
                                     Permissions::CREATE_REVIEWS->value,
                                     Permissions::EDIT_OWN_REVIEWS->value,
                                     Permissions::DELETE_OWN_REVIEWS->value]);

        $adminRole = Role::create(['name' => Roles::ADMIN->value]);
        $adminRole->givePermissionTo([Permission::all()]);
    }
}
