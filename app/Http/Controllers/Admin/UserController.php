<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9]+$/|unique:users,id_number',
            'address' => 'required|max:255',
            'phone' => 'required|digits_between:7,15',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $role = Role::find($data['role_id']);
        $user->assignRole($role->name);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado correctamente',
            'text' => 'El usuario ha sido creado correctamente.',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9]+$/|unique:users,id_number,' . $user->id,
            'address' => 'required|max:255',
            'phone' => 'required|digits_between:7,15',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($data);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $role = Role::find($data['role_id']);
        $user->syncRoles([$role->name]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado correctamente',
            'text' => 'El usuario ha sido actualizado correctamente',
        ]);

        return redirect()->route('admin.users.edit', $user);
    }

    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'No puedes eliminarte a ti mismo',
                'text' => 'No puedes eliminar tu propio usuario',
            ]);

            abort(403, 'No puedes eliminar tu propio usuario');
        }

        $user->roles()->detach();
        $user->delete();

        session()->flash('swal', [
            'title' => 'Usuario eliminado correctamente',
            'icon' => 'success',
            'text' => 'El usuario ha sido eliminado correctamente',
        ]);

        return redirect()->route('admin.users.index');
    }
}
