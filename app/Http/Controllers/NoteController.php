<?php

namespace App\Http\Controllers;

use App\Models\Note; // Importa el modelo Note
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa la fachada Auth

class NoteController extends Controller
{
    // Constructor para aplicar el middleware 'auth'
    // Esto asegura que todas las acciones en este controlador requieran autenticación
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra una lista de todas las notas del usuario autenticado.
     */
    public function index()
    {
        // Obtener solo las notas del usuario autenticado
        $notes = Auth::user()->notes()->latest()->paginate(10);
        return view('notes.index', compact('notes'));
    }

    /**
     * Muestra el formulario para crear una nueva nota.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Almacena una nueva nota en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Crear la nota asociada al usuario autenticado
        Auth::user()->notes()->create($request->all());

        return redirect()->route('notes.index')
                         ->with('success', 'Nota creada exitosamente.');
    }

    /**
     * Muestra los detalles de una nota específica (asegurando que pertenezca al usuario).
     */
    public function show(Note $note)
    {
        // Asegurarse de que el usuario autenticado sea el dueño de la nota
        if (Auth::id() !== $note->user_id) {
            abort(403, 'Acceso no autorizado.');
        }
        return view('notes.show', compact('note'));
    }

    /**
     * Muestra el formulario para editar una nota (asegurando que pertenezca al usuario).
     */
    public function edit(Note $note)
    {
        // Asegurarse de que el usuario autenticado sea el dueño de la nota
        if (Auth::id() !== $note->user_id) {
            abort(403, 'Acceso no autorizado.');
        }
        return view('notes.edit', compact('note'));
    }

    /**
     * Actualiza una nota existente en la base de datos (asegurando que pertenezca al usuario).
     */
    public function update(Request $request, Note $note)
    {
        // Asegurarse de que el usuario autenticado sea el dueño de la nota
        if (Auth::id() !== $note->user_id) {
            abort(403, 'Acceso no autorizado.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')
                         ->with('success', 'Nota actualizada exitosamente.');
    }

    /**
     * Elimina una nota de la base de datos (asegurando que pertenezca al usuario).
     */
    public function destroy(Note $note)
    {
        // Asegurarse de que el usuario autenticado sea el dueño de la nota
        if (Auth::id() !== $note->user_id) {
            abort(403, 'Acceso no autorizado.');
        }

        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Nota eliminada exitosamente.');
    }
}