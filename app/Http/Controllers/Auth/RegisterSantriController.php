<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterSantriController extends Controller
{
    /**
     * Menampilkan form pendaftaran santri.
     */
    public function create(): View
    {
        return view('auth.register-santri');
    }

    /**
     * Menangani proses penyimpanan data santri baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI INPUT
        // Kita sesuaikan dengan name="..." yang ada di HTML
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // HTML mengirim 'role' (santri_putra/santri_putri), bukan 'jenis_kelamin'
            'role' => ['required', 'string', 'in:santri_putra,santri_putri'],
            
            // HTML mengirim 'class_id', bukan 'kelas'
            'class_id' => ['required', 'string', 'max:50'],
            
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ], [
            // Pesan Error Bahasa Indonesia
            'name.required' => 'Nama lengkap wajib diisi',
            'email.unique' => 'Email ini sudah terdaftar, silakan login',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Jenis kelamin (Putra/Putri) wajib dipilih',
            'class_id.required' => 'Kelas wajib dipilih',
        ]);

        // 2. SIMPAN KE DATABASE
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,          // Langsung ambil dari request
            'class_id' => $request->class_id,  // Masuk ke kolom class_id
            'no_telepon' => $request->no_telepon,
            
            // 3. NILAI DEFAULT (PENTING!)
            // Disesuaikan dengan screenshot Database phpMyAdmin
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0, // PERBAIKAN: Sesuai nama kolom di DB
            'current_streak' => 0,
            'longest_streak' => 0,
        ]);

        // 4. PROSES LOGIN OTOMATIS
        event(new Registered($user));
        Auth::login($user);

        // 5. REDIRECT KE DASHBOARD
        // Menggunakan 'route' yang aman. Jika route 'santri.dashboard' tidak ada, 
        // bisa ganti ke 'dashboard' saja.
        return redirect(route('dashboard', absolute: false));
    }
}