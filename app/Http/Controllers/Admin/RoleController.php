<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $roles]);
        }

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Gunakan endpoint store untuk menambahkan role']);
        }

        return view('admin.roles.create');
    }

    // Simpan role baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil ditambahkan',
                'data' => $role
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    // Edit role
    public function edit(Role $role)
    {
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $role]);
        }

        return view('admin.roles.edit', compact('role'));
    }

    // Update role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diperbarui',
                'data' => $role
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui');
    }

    // Hapus role
    public function destroy(Role $role)
    {
        $role->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus'
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}
