@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Skor Game: {{ $game->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    @if($game->type === 'tebak_gambar') 🖼️ Tebak Kosakata dari Gambar
                    @elseif($game->type === 'kosakata_tempat') 🏠 Kosakata di 30 Tempat
                    @elseif($game->type === 'pilihan_ganda') ✅ Pilihan Ganda Melengkapi Kalimat
                    @else 💬 Percakapan di 20 Tempat
                    @endif
                </p>
            </div>
            <div class="flex space-x-3">
                <!-- BUTTON MATRIX REVIEW - BARU! -->
                <a href="{{ route('ustadz.scores.matrix', $game->id) }}" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition font-semibold">
                    📊 Matrix Review
                </a>
                <a href="{{ route('ustadz.scores.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Game Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pengerjaan</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $scores->total() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <span class="text-3xl">📊</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Rata-rata Skor</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">
                                @if($scores->count() > 0)
                                    {{ number_format($scores->avg(function($score) { return ($score->correct_answers / $score->total_questions) * 100; }), 1) }}
                                @else
                                    0
                                @endif
                            </p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <span class="text-3xl">📈</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Skor Tertinggi</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">
                                @if($scores->count() > 0)
                                    {{ number_format($scores->max(function($score) { return ($score->correct_answers / $score->total_questions) * 100; }), 0) }}
                                @else
                                    0
                                @endif
                            </p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-4">
                            <span class="text-3xl">🏆</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Santri Unik</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $scores->pluck('user_id')->unique()->count() }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-4">
                            <span class="text-3xl">👥</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scores List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                    <h2 class="text-2xl font-bold text-white">Detail Skor</h2>
                    <p class="text-white text-sm opacity-90 mt-1">Daftar semua pengerjaan game ini</p>
                </div>

                @if($scores->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Santri
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Skor
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Benar/Total
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Persentase
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($scores as $score)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-3xl mr-3">
                                                    @if($score->user->role === 'santri_putra') 👨‍🎓
                                                    @else 👩‍🎓
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $score->user->name }}</div>
                                                    <div class="text-xs text-gray-500">Level {{ $score->user->level }} • {{ $score->user->experience_points ?? 0 }} XP</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $scoreValue = ($score->correct_answers / $score->total_questions) * 100;
                                            @endphp
                                            @if($scoreValue >= 80)
                                                <span class="px-5 py-2 inline-flex text-2xl leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @elseif($scoreValue >= 60)
                                                <span class="px-5 py-2 inline-flex text-2xl leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @else
                                                <span class="px-5 py-2 inline-flex text-2xl leading-5 font-bold rounded-full bg-purple-100 text-purple-800">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ $score->correct_answers }}/{{ $score->total_questions }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="w-full bg-gray-200 rounded-full h-3">
                                                <div class="h-3 rounded-full {{ $scoreValue >= 80 ? 'bg-green-500' : ($scoreValue >= 60 ? 'bg-blue-500' : 'bg-purple-500') }}" 
                                                     style="width: {{ $scoreValue }}%">
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1">{{ number_format($scoreValue, 1) }}%</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($scoreValue >= 80)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    🌟 Excellent
                                                </span>
                                            @elseif($scoreValue >= 60)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    👍 Good
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    💪 Keep Going
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="font-medium">{{ $score->completed_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $score->completed_at->format('H:i') }}</div>
                                            <div class="text-xs text-gray-400">{{ $score->completed_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('ustadz.scores.detail', $score->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium inline-block">
                                                👁️ Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $scores->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📊</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Yang Mengerjakan</h3>
                        <p class="text-gray-500 mb-6">Belum ada santri yang mengerjakan game "{{ $game->title }}"</p>
                        <a href="{{ route('ustadz.games.show', $game->id) }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition">
                            📝 Kelola Game Ini
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection