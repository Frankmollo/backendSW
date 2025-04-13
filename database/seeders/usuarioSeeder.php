<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class usuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'nombre' => 'MOYADMIN',
            'apellido' => 'SUPER-ROOT',
            'fecha_nacimiento'=>'08-10-1993',
            'correo'=>'admin@gmail.com',
            'password'=>bcrypt('0123456789'),
            'rol_id'=>1
            //''=>
        ]);
    }
}
