<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Para hashear la contraseña
use Illuminate\Validation\Rule; // Para reglas de validación únicas
use Illuminate\Support\Facades\Log; // Para depuración

class UserController extends Controller
{
    // Constructor para aplicar middleware de autenticación
    public function __construct()
    {
        // Protege todas las rutas de este controlador excepto las que se indiquen
        $this->middleware('auth');
        // Más adelante, podríamos añadir middleware de roles si es necesario:
        // $this->middleware('can:manage-users'); // Requiere Gate/Policy
    }

    /**
     * Muestra una lista general de usuarios (activos e inactivos).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Permite filtrar por estado activo/inactivo si se pasa 'status' en la URL
        $query = User::query();

        if ($request->has('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('is_active', $request->status === 'active');
        }

        // Pagina los resultados, ordenando por nombre por defecto
        $users = $query->orderBy('name')->paginate(10); // Paginar 10 usuarios por página

        return view('users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        return view('users.create', compact('roles', 'departments'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Email único
            'password' => 'required|string|min:8|confirmed', // 'confirmed' busca 'password_confirmation'
            'role_id' => 'required|exists:roles,id', // El rol debe existir en la tabla 'roles'
            'department_id' => 'required|exists:departments,id', // El departamento debe existir
            'is_active' => 'boolean', // Debe ser un booleano
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashear la contraseña
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'is_active' => $request->boolean('is_active'), // Obtener como booleano
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $departments = Department::all();
        return view('users.edit', compact('user', 'roles', 'departments'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Ignorar el email del usuario actual al validar unicidad
            ],
            'password' => 'nullable|string|min:8|confirmed', // Nullable para no requerir cambio de contraseña
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->is_active = $request->boolean('is_active');

        if ($request->filled('password')) { // Solo actualiza la contraseña si se proporciona una nueva
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Cambia el estado 'is_active' de un usuario.
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active; // Invierte el estado
        $user->save();

        $statusMessage = $user->is_active ? 'activado' : 'desactivado';
        return redirect()->route('users.index')->with('success', "Usuario {$user->name} ha sido {$statusMessage} exitosamente.");
    }
}