<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadir columna para el ID del rol
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('set null');
            // Añadir columna para el ID del departamento
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            // Añadir un estado de usuario (activo/inactivo)
            $table->boolean('is_active')->default(true); // true por defecto para usuarios activos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar las claves foráneas primero
            $table->dropConstrainedForeignId('role_id');
            $table->dropConstrainedForeignId('department_id');
            // Eliminar las columnas
            $table->dropColumn('is_active');
        });
    }
};