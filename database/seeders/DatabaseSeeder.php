<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar el modelo User
use App\Models\Order; // Asegúrate de importar el modelo Order
use App\Models\Role; // Asegúrate de importar el modelo Role
use App\Models\Department; // Asegúrate de importar el modelo Department

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Siembra la base de datos de la aplicación.
     */
    public function run(): void
    {
        // Ejecutar los seeders en orden para asegurar que los roles y departamentos existan
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
        ]);

        // Crear un usuario administrador específico (siempre es útil para login)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Hash::make('password'), // Contraseña: password
            'role_id' => Role::where('name', 'Admin')->first()->id, // Asigna el rol de Admin
            'department_id' => Department::where('name', 'Administracion')->first()->id, // Asigna un departamento de Administración
            'is_active' => true,
        ]);

        // Crear usuarios de prueba con roles y departamentos aleatorios
        User::factory(10)->create(); // Crea 10 usuarios adicionales (tendrán roles y deptos aleatorios de los seeders)

        // Crear órdenes de prueba para usuarios existentes
        Order::factory(50)->create(); // Crea 50 órdenes (se asignarán a usuarios existentes)
    }
}
