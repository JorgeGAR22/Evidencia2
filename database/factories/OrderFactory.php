<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Log; // Importar la clase Log

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Asegurarse de que existan usuarios antes de crear órdenes
        // Esto debería funcionar ya que DatabaseSeeder crea usuarios primero.
        $userId = User::inRandomOrder()->first()->id;

        // Si por alguna razón no hay usuarios (lo cual no debería pasar después de User::factory(10)->create()),
        // crea uno para evitar errores.
        if (is_null($userId)) {
            $userId = User::factory()->create()->id;
        }

        $statuses = ['pending', 'in_process', 'in_route', 'delivered', 'cancelled'];
        $status = $this->faker->randomElement($statuses);

        $processName = null;
        $processDate = null;
        $inRoutePhotoPath = null;
        $deliveredPhotoPath = null;

        if ($status === 'in_process') {
            $processName = $this->faker->words(2, true) . ' process';
            $processDate = $this->faker->dateTimeBetween('-1 week', 'now');
        } elseif ($status === 'in_route') {
            $processName = 'Shipping';
            $processDate = $this->faker->dateTimeBetween('-2 days', '-1 day');
            $inRoutePhotoPath = 'photos/in_route/' . $this->faker->uuid() . '.jpg';
        } elseif ($status === 'delivered') {
            $processName = 'Delivery completed';
            $processDate = $this->faker->dateTimeBetween('-5 days', '-2 days');
            $inRoutePhotoPath = 'photos/in_route/' . $this->faker->uuid() . '.jpg';
            $deliveredPhotoPath = 'photos/delivered/' . $this->faker->uuid() . '.jpg';
        }

        $attributes = [
            'user_id' => $userId,
            'invoice_number' => 'INV-' . $this->faker->unique()->randomNumber(6),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'shipping_address' => $this->faker->address(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $status,
            'process_name' => $processName,
            'process_date' => $processDate,
            'in_route_photo_path' => $inRoutePhotoPath,
            'delivered_photo_path' => $deliveredPhotoPath,
        ];

        // Línea de depuración: Imprime los atributos que la factory está generando
        Log::info('OrderFactory generating attributes:', $attributes);

        return $attributes;
    }
}
