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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El usuario que creó la orden
            $table->string('invoice_number')->unique(); // Número de factura (único)
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('shipping_address');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'in_process', 'in_route', 'delivered', 'cancelled'])->default('pending');
            $table->string('process_name')->nullable(); // Nombre del proceso si está 'in_process'
            $table->timestamp('process_date')->nullable(); // Fecha del proceso
            $table->string('in_route_photo_path')->nullable(); // Ruta de la foto para estado 'in_route'
            $table->string('delivered_photo_path')->nullable(); // Ruta de la foto para estado 'delivered'
            $table->timestamps();
            $table->softDeletes(); // Para eliminación lógica (archivar órdenes)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};