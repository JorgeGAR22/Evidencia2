<?php

namespace Database\Seeders; // Asegúrate que el namespace sea el correcto: Database\Seeders

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department; // Asegúrate de importar el modelo Department

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Ejecuta los seeders de la base de datos.
     */
    public function run(): void
    {
        // Crea los departamentos si no existen
        Department::firstOrCreate(['name' => 'Ventas'], ['description' => 'Departamento encargado de las ventas y atención al cliente.']);
        Department::firstOrCreate(['name' => 'Logistica'], ['description' => 'Departamento encargado de la gestión de pedidos y envíos.']);
        Department::firstOrCreate(['name' => 'Finanzas'], ['description' => 'Departamento encargado de la contabilidad y finanzas.']);
        Department::firstOrCreate(['name' => 'Recursos Humanos'], ['description' => 'Departamento encargado del personal.']);
        Department::firstOrCreate(['name' => 'Administracion'], ['description' => 'Departamento encargado de la administración general.']); // Añadido para el usuario Admin
    }
}

