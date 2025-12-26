<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game; // 1. DIPERLUKAN KARENA TIDAK ADA DI FILE ASLI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// ... existing code ...
    public function index()
    {
        $games = Game::with('creator')->latest()->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
// ... existing code ...
    public function create()
    {
        return view('admin.games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
// ... existing code ...
    {
        $validated = $request->validate([
            'type' => 'required|in:tebak_gambar,kosakata_tempat,pilihan_ganda,percakapan',
            'title' => 'required|string|max:255',
// ... existing code ...
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        // Status otomatis 'draft' by default dari migrasi

        Game::create($validated);

        return redirect()->route('admin.games.index')
// ... existing code ...
            ->with('success', 'Game berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
// ... existing code ...
    public function show(Game $game)
    {
        $game->load('questions');
        return view('admin.games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
// ... existing code ...
    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
// ... existing code ...
    {
        $validated = $request->validate([
            'type' => 'required|in:tebak_gambar,kosakata_tempat,pilihan_ganda,percakapan',
            'title' => 'required|string|max:255',
// ... existing code ...
            'description' => 'nullable|string',
        ]);

        $game->update($validated);

        return redirect()->route('admin.games.index')
// ... existing code ...
            ->with('success', 'Game berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
// ... existing code ...
    {
        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil dihapus!');
    }

    /**
     * DITAMBAHKAN: Method baru untuk Publish/Unpublish Game
     */
    public function toggleStatus(Game $game)
    {
        // Keamanan: Jangan biarkan game di-publish jika tidak ada soal
        if ($game->status == 'draft' && $game->questions()->count() == 0) {
            return back()->with('error', 'Game tidak bisa di-publish karena belum memiliki soal.');
        }

        // Toggle status
        if ($game->status == 'draft') {
            $game->status = 'published';
            $message = 'Game berhasil di-publish!';
        } else {
            $game->status = 'draft';
            $message = 'Game berhasil di-unpublish (disimpan sebagai draft).';
        }
        
        $game->save();

        return redirect()->route('admin.games.index')
            ->with('success', $message);
    }
}