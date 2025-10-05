<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\JenisPekerja;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KelolaAkunController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'jenisPekerja'])
                    ->where('role_id', 3) // Only show users with role_id = 3 (user role)
                    ->get();
        $roles = Role::all();
        $jenisPekerja = JenisPekerja::all();
        
        return view('admin.kelola_akun.index', compact('users', 'roles', 'jenisPekerja'));
    }

    public function create()
    {
        $roles = Role::where('id', 3)->get(); // Only show user role (role_id = 3)
        $jenisPekerja = JenisPekerja::all();
        
        return view('admin.kelola_akun.create', compact('roles', 'jenisPekerja'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'jenis_pekerja' => 'required|array|min:1',
            'jenis_pekerja.*' => 'exists:jenis_pekerja,id',
            'keahlian' => 'required|string|max:255',
            'no_sib' => 'required|string|max:255',
            'npr' => 'required|string|max:255',
            'berlaku' => 'required|date',
            'is_active' => 'required|boolean',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle foto profil upload
        $fotoProfilPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoProfilPath = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'keahlian' => $request->keahlian,
            'npr' => $request->npr,
            'no_sib' => $request->no_sib,
            'berlaku' => $request->berlaku,
            'is_active' => $request->is_active,
            'foto_profil' => $fotoProfilPath,
        ]);

        // Attach jenis pekerja (many-to-many relationship)
        if ($request->has('jenis_pekerja')) {
            $user->jenisPekerja()->attach($request->jenis_pekerja);
        }

        return redirect()->route('admin.kelola_akun')
            ->with('success', 'Akun berhasil dibuat!');
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'User not found']);
        }
        $user->is_active = !$user->is_active;
        $user->save();
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $user = User::with(['role', 'jenisPekerja'])->findOrFail($id);
        $roles = Role::where('id', 3)->get(); // Only show user role (role_id = 3)
        $jenisPekerja = JenisPekerja::all();
        
        return view('admin.kelola_akun.edit', compact('user', 'roles', 'jenisPekerja'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'jenis_pekerja' => 'required|array|min:1',
            'jenis_pekerja.*' => 'exists:jenis_pekerja,id',
            'keahlian' => 'required|string|max:255',
            'no_sib' => 'required|string|max:255',
            'npr' => 'required|string|max:255',
            'berlaku' => 'required|date',
            'is_active' => 'required|boolean',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::findOrFail($id);

        // Handle foto profil update
        $fotoProfilPath = $user->foto_profil;
        if ($request->hasFile('foto_profil')) {
            // Delete old file if exists
            if ($fotoProfilPath && Storage::disk('public')->exists($fotoProfilPath)) {
                Storage::disk('public')->delete($fotoProfilPath);
            }
            $fotoProfilPath = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'keahlian' => $request->keahlian,
            'npr' => $request->npr,
            'no_sib' => $request->no_sib,
            'berlaku' => $request->berlaku,
            'is_active' => $request->is_active,
            'foto_profil' => $fotoProfilPath,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $passwordValidator = Validator::make($request->only('password', 'password_confirmation'), [
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($passwordValidator->fails()) {
                return redirect()->back()
                    ->withErrors($passwordValidator)
                    ->withInput();
            }

            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Sync jenis pekerja
        $user->jenisPekerja()->sync($request->jenis_pekerja);

        return redirect()->route('admin.kelola_akun')
            ->with('success', 'Akun berhasil diperbarui!');
    }
} 