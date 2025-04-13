<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            /**
             * ROLES
             */
            'ver_roles',
            'crear_roles',
            'editar_roles',
            'eliminar_roles',
            /**
             * USUARIOS
             */
            'crear_usuarios',
            'ver_usuarios',
            'eliminar_usuarios',
            'editar_usuarios',
            /**
             * PERMISOS
             */
            'ver_permisos_rol',
            'actualizar_permisos_rol'
        ];

        foreach ($permisos as $permiso) {
            Permiso::firstOrCreate(['nombre' => $permiso]);
        }

        // Asignar permisos al rol Admin
        $admin = Rol::firstOrCreate(['nombre' => 'Admin']);
        $admin->permisos()->sync(Permiso::pluck('id'));
    }
}
