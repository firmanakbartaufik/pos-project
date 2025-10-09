<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $users]);
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Roles::all();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $roles]);
        }

        return view('users.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = bcrypt('password');

        $user = User::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan dengan password default',
                'data' => $user
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan dengan password default');
    }

    // Edit user
    public function edit(User $user)
    {
        $roles = Roles::all();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'roles' => $roles
                ]
            ]);
        }

        return view('users.edit', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui',
                'data' => $user
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // Hapus user
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

}
