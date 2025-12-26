@extends('layouts.santri')

@section('title', 'Mendengarkan dan Bermain - Pilih Level')

@push('styles')
<style>
    .level-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .level-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .level-icon {
        font-size: 4rem;
        display: block;
        margin-bottom: 1rem;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-bounce-slow {
        animation: bounce 2s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="inline-block animate-bounce-slow mb-4">
            <span class="text-7xl">🎧</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            <span class="bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                Mendengarkan dan Bermain
            </span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Asah kemampuan mendengarkan bahasa Arab Anda! Pilih level sesuai kemampuan dan mulai bermain.
        </p>
    </div>

    <!-- Level Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        
        @foreach($levels as $key => $level)
        <div class="level-card bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-{{ $level['color'] }}-200 hover:border-{{ $level['color'] }}-400"
             onclick="selectLevel('{{ $key }}')">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-br from-{{ $level['color'] }}-500 to-{{ $level['color'] }}-600 text-white p-6 text-center">
                <span class="level-icon">{{ $level['icon'] }}</span>
                <h2 class="text-2xl font-bold mb-2 font-arabic">{{ $level['name'] }}</h2>
                <p class="text-lg font-semibold opacity-90">{{ $level['name_id'] }}</p>
            </div>
            
            <!-- Card Body -->
            <div class="p-6">
                <p class="text-gray-700 text-center mb-6 min-h-[60px]">
                    {{ $level['description'] }}
                </p>
                
                <!-- Level Info -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <span class="text-sm text-gray-600 font-medium">Soal:</span>
                        <span class="text-sm font-bold text-{{ $level['color'] }}-600">10 Pertanyaan</span>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <span class="text-sm text-gray-600 font-medium">Waktu/Soal:</span>
                        <span class="text-sm font-bold text-{{ $level['color'] }}-600">
                            @if($key === 'low') 20 detik
                            @elseif($key === 'medium') 30 detik
                            @else 45 detik
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <span class="text-sm text-gray-600 font-medium">Percobaan:</span>
                        <span class="text-sm font-bold text-{{ $level['color'] }}-600">3x</span>
                    </div>
                </div>
                
                <!-- Play Button -->
                <button onclick="selectLevel('{{ $key }}')" 
                        class="w-full bg-gradient-to-r from-{{ $level['color'] }}-500 to-{{ $level['color'] }}-600 hover:from-{{ $level['color'] }}-600 hover:to-{{ $level['color'] }}-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                        </svg>
                        Mulai Bermain
                    </span>
                </button>
            </div>
        </div>
        @endforeach
        
    </div>

    <!-- Tips Section -->
    <div class="mt-16 max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl shadow-lg p-8 border-2 border-blue-200">
            <div class="flex items-start gap-4">
                <div class="text-5xl">💡</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Tips Bermain:</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start gap-3">
                            <span class="text-green-600 font-bold">✓</span>
                            <span>Gunakan headphone atau speaker yang jelas untuk mendengarkan audio dengan baik</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-600 font-bold">✓</span>
                            <span>Dengarkan audio beberapa kali sebelum menjawab</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-600 font-bold">✓</span>
                            <span>Perhatikan harakat (tanda baca) pada setiap pilihan jawaban</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-600 font-bold">✓</span>
                            <span>Gunakan hint (petunjuk) jika kesulitan, tapi akan mengurangi 5 poin</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-600 font-bold">✓</span>
                            <span>Streak bonus: jawab benar berturut-turut untuk mendapat poin tambahan!</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-12">
        <a href="{{ route('santri.games.index') }}" 
           class="inline-flex items-center gap-2 text-gray-600 hover:text-teal-600 font-semibold transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Game
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectLevel(level) {
    // Simpan level ke localStorage
    localStorage.setItem('selected_listening_level', level);
    
    // Show loading indicator
    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loadingDiv.innerHTML = `
        <div class="bg-white rounded-2xl p-8 text-center shadow-2xl">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mx-auto mb-4"></div>
            <p class="text-lg font-semibold text-gray-700">Memuat game...</p>
        </div>
    `;
    document.body.appendChild(loadingDiv);
    
    // Redirect ke halaman play
    setTimeout(() => {
        window.location.href = '{{ route("santri.listening.play") }}';
    }, 500);
}

// Clear any existing session when page loads
window.addEventListener('DOMContentLoaded', () => {
    // Optional: Clear previous session
    // localStorage.removeItem('selected_listening_level');
});
</script>
@endpush