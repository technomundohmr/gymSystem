<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $roles = Roles::all();
        return response()->json($roles);
    }

    /**
     * Almacena un recurso recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            Roles::create($request->all());
            return response()->json(['message'=> 'role created succesfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'there was an error: ' . $th]);
        }
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Roles $role)
    {
        return response()->json($role);
    }

    /**
     * Actualiza el recurso especificado en la base de datos.
     */
    public function update(Request $request, Roles $role)
    {
        $name = $request->all()['name'];
        try {
            $role->update(['name' => $name]);
            return response()->json(['message'=> 'role updated succesfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'there was an error: ' . $th]);
        }
    }

    /**
     * Elimina el recurso especificado de la base de datos.
     */
    public function destroy(Roles $role)
    {
        try {
            $role->delete();
            return response()->json(['message'=> 'role deleted succesfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'there was an error: ' . $th]);
        }
    }
}
