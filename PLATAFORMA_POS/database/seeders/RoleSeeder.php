<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Empleado']);

        Permission::create(['name' => 'Acceso al Dashboard'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Acceso a la Configuración'])->syncRoles([$role1]);
        Permission::create(['name' => 'Acceso a los Proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'Acceso a los Productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Acceso a las Compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'Acceso a las Ventas'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Acceso a los Clientes'])->syncRoles([$role1,$role2]);

    }
}
