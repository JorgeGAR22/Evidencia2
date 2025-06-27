<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Asegúrate de importar el modelo Role

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Ejecuta los seeders de la base de datos.
     */
    public function run(): void
    {
        // Crea los roles si no existen
        Role::firstOrCreate(['name' => 'Admin'], ['description' => 'Administrador del sistema con acceso completo.']);
        Role::firstOrCreate(['name' => 'Manager'], ['description' => 'Gerente con permisos de supervisión.']);
        Role::firstOrCreate(['name' => 'Employee'], ['description' => 'Empleado con acceso a funcionalidades básicas.']);
        Role::firstOrCreate(['name' => 'Client'], ['description' => 'Cliente externo, con acceso limitado a sus propios datos.']);
    }
}
