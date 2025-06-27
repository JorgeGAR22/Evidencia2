<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User; // Para asignar órdenes a usuarios
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Para gestionar archivos (fotos)
use Illuminate\Support\Facades\Log; // Para depuración
use Illuminate\Validation\Rule; // Para reglas de validación

class OrderController extends Controller
{
    // Constructor para aplicar middleware de autenticación
    public function __construct()
    {
        $this->middleware('auth');
        // Middleware para proteger acciones sensibles basadas en roles
        // Ejemplo: Solo Admin/Sales pueden crear, solo Warehouse/Route pueden actualizar estado, etc.
        // Esto requeriría Gates/Policies o un middleware de rol más complejo.
        // Por ahora, asumiremos que los usuarios autenticados pueden realizar estas acciones.
    }

    /**
     * Muestra una lista de todas las órdenes, ordenadas de la última a la primera.
     * Permite buscar por número de factura, número de cliente, fecha o estado.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Order::active()->orderBy('created_at', 'desc'); // Órdenes activas, de la última a la primera

        // Lógica de búsqueda
        if ($request->filled('search_invoice_number')) {
            $query->where('invoice_number', 'like', '%' . $request->search_invoice_number . '%');
        }
        if ($request->filled('search_customer_name')) { // En la descripción original dice "Customer Number", pero el modelo tiene "customer_name"
            $query->where('customer_name', 'like', '%' . $request->search_customer_name . '%');
        }
        if ($request->filled('search_date')) {
            $query->whereDate('created_at', $request->search_date);
        }
        if ($request->filled('search_status') && $request->search_status !== 'all') {
            $query->where('status', $request->search_status);
        }

        $orders = $query->paginate(10); // Paginar los resultados
        $statuses = ['pending', 'in_process', 'in_route', 'delivered', 'cancelled']; // Para el filtro de estado

        return view('orders.index', compact('orders', 'statuses'));
    }

    /**
     * Muestra el formulario para crear una nueva orden.
     * Solo los usuarios con rol "Sales" (o administradores) deberían poder hacer esto.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Se podría pasar el ID del usuario actual como valor predeterminado si es el que crea la orden
        $users = User::all(); // Para seleccionar a qué usuario se asigna la orden (si aplica)
        return view('orders.create', compact('users'));
    }

    /**
     * Almacena una nueva orden en la base de datos.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|unique:orders,invoice_number|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id', // El usuario que crea la orden
            // El status por defecto es 'pending' y no debería ser modificable en la creación por el usuario
        ]);

        Order::create([
            'user_id' => $request->user_id, // Asignar al usuario seleccionado
            'invoice_number' => $request->invoice_number,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $request->total_amount,
            'status' => 'pending', // Siempre 'pending' al crear
            'process_name' => null,
            'process_date' => null,
            'in_route_photo_path' => null,
            'delivered_photo_path' => null,
        ]);

        return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
    }

    /**
     * Muestra los detalles de una orden específica.
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Muestra el formulario para editar una orden existente.
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        $users = User::all(); // Para cambiar el usuario asignado si es necesario
        $statuses = ['pending', 'in_process', 'in_route', 'delivered', 'cancelled']; // Para el dropdown de estados
        return view('orders.edit', compact('order', 'users', 'statuses'));
    }

    /**
     * Actualiza una orden existente en la base de datos.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'invoice_number' => [
                'required',
                'string',
                Rule::unique('orders', 'invoice_number')->ignore($order->id), // Ignorar el número de factura actual
                'max:255',
            ],
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_process,in_route,delivered,cancelled', // Validar que el estado sea uno de los permitidos
            'process_name' => 'nullable|string|max:255',
            'process_date' => 'nullable|date',
            'in_route_photo' => 'nullable|image|max:2048', // Validación para carga de imagen (2MB máx)
            'delivered_photo' => 'nullable|image|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        // Manejo de carga de fotos
        if ($request->hasFile('in_route_photo')) {
            // Eliminar foto anterior si existe
            if ($order->in_route_photo_path) {
                Storage::delete($order->in_route_photo_path);
            }
            $order->in_route_photo_path = $request->file('in_route_photo')->store('public/orders/in_route');
        }

        if ($request->hasFile('delivered_photo')) {
            // Eliminar foto anterior si existe
            if ($order->delivered_photo_path) {
                Storage::delete($order->delivered_photo_path);
            }
            $order->delivered_photo_path = $request->file('delivered_photo')->store('public/orders/delivered');
        }

        // Actualizar los demás campos
        $order->invoice_number = $request->invoice_number;
        $order->customer_name = $request->customer_name;
        $order->customer_email = $request->customer_email;
        $order->customer_phone = $request->customer_phone;
        $order->shipping_address = $request->shipping_address;
        $order->total_amount = $request->total_amount;
        $order->status = $request->status;
        $order->process_name = $request->process_name;
        $order->process_date = $request->process_date;
        $order->user_id = $request->user_id;

        $order->save();

        return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente.');
    }

    /**
     * Elimina lógicamente una orden.
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $order->delete(); // Esto usa SoftDeletes
        return redirect()->route('orders.index')->with('success', 'Orden archivada (eliminada lógicamente) exitosamente.');
    }

    /**
     * Muestra una lista de órdenes archivadas (eliminadas lógicamente).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function archived(Request $request)
    {
        // Esta línea detendrá la ejecución y mostrará un mensaje si la petición llega aquí
        dd('¡Llegó al controlador de órdenes archivadas!'); 

        $query = Order::onlyTrashed()->orderBy('deleted_at', 'desc'); // Solo las órdenes eliminadas lógicamente

        // Lógica de búsqueda similar a index, pero sobre las archivadas
        if ($request->filled('search_invoice_number')) {
            $query->where('invoice_number', 'like', '%' . $request->search_invoice_number . '%');
        }
        if ($request->filled('search_customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->search_customer_name . '%');
        }
        if ($request->filled('search_date')) {
            $query->whereDate('created_at', $request->search_date);
        }
        // No tiene sentido buscar por 'status' en archivadas, a menos que quieras el status previo al archivo.

        $archivedOrders = $query->paginate(10);
        return view('orders.archived', compact('archivedOrders'));
    }

    /**
     * Restaura una orden eliminada lógicamente.
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id); // Buscar incluso si está eliminada lógicamente
        $order->restore(); // Restaura la orden
        return redirect()->route('orders.archived')->with('success', 'Orden restaurada exitosamente.');
    }
}