<?php

namespace App\Http\Controllers;

use App\Models\User; // Asegúrate de importar el modelo User
use App\Models\Role; // Asumiendo que tienes un modelo Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Para hashear contraseñas

class UserController extends Controller
{
    /**
     * Muestra una lista de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener todos los usuarios, ordenados por nombre
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles para el select
        return view('users.create', compact('roles'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Asegura que el rol exista
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'is_active' => true, // Por defecto, activo al crear
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all(); // Obtener todos los roles para el select
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            // 'password' => 'nullable|string|min:8|confirmed', // Si permites cambiar contraseña aquí
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Cambia el estado (activo/inactivo) de un usuario.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active; // Invierte el estado
        $user->save();

        $status = $user->is_active ? 'activado' : 'desactivado';
        return redirect()->route('users.index')->with('success', "Usuario $user->name $status exitosamente.");
    }
}
