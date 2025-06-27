<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Importar el modelo Order
use Illuminate\Support\Facades\Storage; // Para mostrar fotos si están almacenadas
use Illuminate\Support\Facades\Log; // Para depuración

class HomeController extends Controller
{
    /**
     * Muestra la vista de inicio pública con un formulario de búsqueda.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home_public'); // Esta será la vista para usuarios no registrados
    }

    /**
     * Realiza la búsqueda de órdenes por número de factura (para usuarios no registrados).
     * Muestra el estado y la foto de evidencia si la orden está 'delivered'.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function searchOrder(Request $request)
    {
        // Validar el número de factura
        $request->validate([
            'invoice_number' => 'required|string|max:255',
        ]);

        $invoiceNumber = $request->input('invoice_number');
        // Buscar la orden. Usamos ->first() para obtener un solo resultado.
        $order = Order::where('invoice_number', $invoiceNumber)->first(); 

        $deliveryPhotoUrl = null;
        // Si se encuentra la orden y está entregada y tiene una ruta de foto, generar la URL
        if ($order && $order->status === 'delivered' && $order->delivered_photo_path) {
            // Generar una URL temporal para la foto, asumiendo que está en storage/app/public
            $deliveryPhotoUrl = Storage::url($order->delivered_photo_path);
        }

        // Devolver la vista home_public, pasando la orden encontrada y la URL de la foto
        // La vista maneja si $order es null (no encontrada) o si tiene datos.
        return view('home_public', compact('order', 'deliveryPhotoUrl'));
    }

    /**
     * Muestra el dashboard para usuarios autenticados.
     * Este método fue añadido para corregir el error "Method App\Http\Controllers\HomeController::dashboard does not exist."
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
