<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,ustadz,ustadzah,santri_putra,santri_putri',
            'class_id' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing single user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit-single', compact('user'));
    }

    /**
     * Tampilkan halaman edit massal (Bulk Edit)
     */
    public function editBulk()
    {
        // Mengambil semua user agar variabel $users terdefinisi di view
        $users = User::all(); 
        return view('admin.users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,ustadz,ustadzah,santri_putra,santri_putri',
            'class_id' => 'nullable|string|max:255',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Proses update banyak user sekaligus
     */
    public function bulkUpdate(Request $request)
    {
        // Validasi dasar untuk array users
        $request->validate([
            'users' => 'required|array',
            'users.*.id' => 'required|exists:users,id',
            'users.*.name' => 'required|string|max:255',
            'users.*.email' => 'required|email|max:255',
            'users.*.role' => 'required|in:admin,ustadz,ustadzah,santri_putra,santri_putri',
            'users.*.class_id' => 'nullable|string|max:255',
            'users.*.password' => 'nullable|string|min:8',
        ]);

        $updatedCount = 0;

        foreach ($request->users as $userData) {
            $user = User::find($userData['id']);
            
            if ($user) {
                // Update data dasar
                $updateData = [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'role' => $userData['role'],
                    'class_id' => $userData['class_id'] ?? null,
                ];

                // Update password jika diisi
                if (!empty($userData['password'])) {
                    $updateData['password'] = Hash::make($userData['password']);
                }

                $user->update($updateData);
                $updatedCount++;
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', $updatedCount . ' user berhasil diperbarui secara massal!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}