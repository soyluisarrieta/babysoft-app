<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permission::all();
        $roles = Role::with('permissions')->get();

        return view('admin.roles.index', compact('roles','permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('admin.roles.create' ,compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
          'name' => 'required|alpha|min:3|max:150|unique:roles,name',
          'permisos' => 'required|array|exists:permissions,id',
      ], [
          'name.unique' => 'El nombre del rol ya está en uso.'
      ]);
      try {
          $role = Role::create($request->only('name'));
          
          if ($request->has('permisos')) {
              $role->permissions()->sync($request->permisos);
          }

          return redirect()->route("roles.index", $role)->with('success', 'Rol creado con éxito.');
      } catch (\Exception $e) {
          return redirect()->back()->withInput()->with('error', $e->getMessage());
      }
    }


    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.create' , compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permisos = Permission::all();

        return view('admin.roles.edit' , compact('role','permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')->with('error', 'No se puede editar el rol "Admin".');
        } else {
            $request->validate([
                'name' => 'required|alpha|min:3|max:150|unique:roles,name,' . $role->id,
                'permisos' => 'required|array|exists:permissions,id',
            ], [
                'name.unique' => 'El nombre del rol ya está en uso.'
            ]);
    
            try {
                $role->update($request->only('name'));
    
                if ($request->has('permisos')) {
                    $role->permissions()->sync($request->permisos);
                }
    
                return redirect()->route("roles.index", $role)->with('success', 'Rol editado con éxito.');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }
        }
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol "Admin".');
        }
    
        $role->delete();
    
        return redirect()->route('roles.index')->with('success', 'Rol eliminado con éxito.');
    }
    
}
