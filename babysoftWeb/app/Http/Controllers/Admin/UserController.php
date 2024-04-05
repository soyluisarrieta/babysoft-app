<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
      $request->validate([
          'name' => 'required|string|min:3|max:150',
          'email' => 'required|string|email|min:5|max:150|unique:users',
          'isActived' => 'nullable',
          'roles' => 'required|array',
          'password' => ['required', Password::defaults()],
      ], [
          'email.unique' => 'El correo electrónico ya está en uso.',
          'roles.required' => 'Selecciona al menos un rol.',
      ]);

      try {
          $data = $request->only('name', 'email', 'password', 'isActived');
          $data['password'] = bcrypt($data['password']);
          $data['isActived'] = $request->has('isActived') && $request->input('isActived') === 'on';
          $user = User::create($data);

          if ($request->has('roles')) {
              $user->syncRoles($request->roles);
          }

          return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
      } catch (\Exception $e) {
          return redirect()->back()->withInput()->with('error', $e->getMessage());
      }
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->email === 'admin@gmail.com') {
            return redirect()->route('users.index')->with('error', 'No se puede editar al usuario "Admin".');
        }
    
        $request->validate([
            'name' => 'required|string|min:3|max:150',
            'email' => 'required|string|email|min:5|max:150|unique:users,email,' . $id,
            'isActived' => 'nullable',
            'roles' => 'required|array',
        ], [
            'email.unique' => 'El correo electrónico ya está en uso.',
            'roles.required' => 'Selecciona al menos un rol.',
        ]);
    
        try {
            $data = $request->only('name', 'email');
    
            $user->name = $data['name'];
            $user->email = $data['email'];
            // Modificación para asegurar que isActived se actualice correctamente
            $user->isActived = $request->input('isActived', false);
            $user->syncRoles($request->input('roles', []));
            $user->save();
    
            return redirect()->route('users.index')->with('success', 'Usuario editado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggleActive(Request $request, $id)
    {
        if (Auth::id() == $id) {
            return response()->json(['error' => 'No puedes cambiar tu propio estado.'], 403);
        }
    
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }
    
        $user->isActived = $request->isActived;
        $user->save();
        return response()->json(['success' => 'Estado de usuario actualizado con éxito.']);
    }

}
