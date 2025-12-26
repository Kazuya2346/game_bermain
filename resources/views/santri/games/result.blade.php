@php
    // Safe session retrieval with proper defaults
    $scoreValue = session('scoreValue', 0);
    $correctAnswers = session('correctAnswers', 0);
    $totalQuestions = session('totalQuestions', 1);
    $xpEarned = session('xpEarned', 0);
    $newLevel = session('newLevel', auth()->user()->level ?? 1);
    $levelName = session('levelName', 'Pemula');
    
    // Ensure variables exist for view
    $levelInfo = $levelInfo ?? ['progress_percentage' => 0, 'current_xp' => 0, 'max_xp' => 100];
    $badge = $badge ?? ['emoji' => '⭐', 'name' => 'Beginner'];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Game - TPQ Arabic Learning</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        /* Celebration animation */
        .celebration {
            animation: celebrate 1.5s ease-in-out infinite alternate;
        }
        @keyframes celebrate {
            0% { transform: scale(1) rotate(-5deg); }
            100% { transform: scale(1.15) rotate(5deg); }
        }
        
        /* Enhanced glow text animation */
        .glow {
            text-shadow: 0 0 15px rgba(255,255,255,0.9),
                         0 0 30px rgba(255,255,255,0.7),
                         0 0 45px rgba(255,255,255,0.5),
                         0 0 60px rgba(255,255,255,0.3);
            animation: glow-pulse 2s ease-in-out infinite;
        }
        @keyframes glow-pulse {
            0%, 100% { text-shadow: 0 0 15px rgba(255,255,255,0.9), 0 0 30px rgba(255,255,255,0.7); }
            50% { text-shadow: 0 0 25px rgba(255,255,255,1), 0 0 50px rgba(255,255,255,0.9), 0 0 75px rgba(255,255,255,0.7); }
        }
        
        /* Floating animation for cards */
        .float {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-12px) scale(1.02); }
        }
        
        /* Score number dramatic entrance */
        .score-entrance {
            animation: score-pop 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        @keyframes score-pop {
            0% { transform: scale(0) rotate(-180deg); opacity: 0; }
            70% { transform: scale(1.2) rotate(10deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        
        /* Confetti animation */
        .confetti {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }
        .confetti span {
            position: absolute;
            width: 10px; height: 20px;
            background: hsl(calc(360 * var(--hue)), 85%, 65%);
            top: -10%;
            left: calc(100% * var(--x));
            animation: fall var(--dur) linear infinite;
            opacity: 0.85;
            transform: rotate(0deg);
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }
        @keyframes fall {
            to {
                transform: translateY(110vh) rotate(720deg);
                opacity: 0;
            }
        }
        
        /* Sparkle effect */
        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            animation: sparkle-twinkle var(--duration) ease-in-out infinite;
            box-shadow: 0 0 10px 2px rgba(255,255,255,0.8);
        }
        @keyframes sparkle-twinkle {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1.5); }
        }
        
        /* Gradient animation */
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 4s ease infinite;
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Button pulse effect */
        .button-pulse {
            animation: button-pulse-anim 2s ease-in-out infinite;
        }
        @keyframes button-pulse-anim {
            0%, 100% { box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7); }
            50% { box-shadow: 0 0 0 15px rgba(168, 85, 247, 0); }
        }
        
        /* Card entrance animation */
        .card-entrance {
            animation: card-slide-up 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes card-slide-up {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        /* Stat card stagger */
        .stat-card-1 { animation-delay: 0.2s; }
        .stat-card-2 { animation-delay: 0.4s; }
        .stat-card-3 { animation-delay: 0.6s; }
        
        /* Shimmer effect */
        .shimmer {
            position: relative;
            overflow: hidden;
        }
        .shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer-slide 3s infinite;
        }
        @keyframes shimmer-slide {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        /* Ripple effect on hover */
        .ripple-effect {
            position: relative;
            overflow: hidden;
        }
        .ripple-effect::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .ripple-effect:hover::after {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-100 via-pink-50 to-blue-100 min-h-screen relative">

    <!-- Confetti (decorative only, non-blocking) -->
    <div class="confetti" aria-hidden="true">
        @for ($i = 0; $i < 80; $i++)
            <span style="--x: {{ fmod($i * 0.0125, 1) }}; --hue: {{ $i * 4.5 }}; --dur: {{ rand(6, 12) }}s; animation-delay: {{ $i * 0.05 }}s;"></span>
        @endfor
    </div>

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-xl shadow-xl fixed top-0 w-full z-50 border-b-2 border-purple-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">🕌 TPQ Arabic</span>
                <span class="text-gray-700 font-semibold flex items-center gap-2">
                    <span class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                    {{ auth()->user()->name }}
                </span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">

        <!-- Result Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden card-entrance transform hover:shadow-[0_0_60px_rgba(168,85,247,0.4)] transition-all duration-700">

            <!-- Header with Sparkles -->
            <div class="@if($scoreValue>=80) bg-gradient-to-br from-green-400 via-emerald-500 to-teal-500 gradient-animate 
                        @elseif($scoreValue>=60) bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-500 gradient-animate 
                        @else bg-gradient-to-br from-orange-400 via-red-500 to-pink-500 gradient-animate 
                        @endif p-12 text-center text-white relative overflow-hidden shimmer">
                
                <!-- Animated pulse overlay -->
                <div class="absolute inset-0 bg-white/10 animate-pulse"></div>
                
                <!-- Sparkles -->
                @for($i = 0; $i < 15; $i++)
                    <div class="sparkle" style="top: {{ rand(10, 90) }}%; left: {{ rand(10, 90) }}%; --duration: {{ rand(15, 30) / 10 }}s; animation-delay: {{ $i * 0.2 }}s;"></div>
                @endfor
                
                <div class="relative z-10">
                    <div class="text-9xl mb-6 celebration drop-shadow-2xl filter brightness-110">
                        @if($scoreValue>=80) 🎉 @elseif($scoreValue>=60) 👏 @else 💪 @endif
                    </div>
                    <h1 class="text-6xl font-black mb-4 glow tracking-tight">
                        @if($scoreValue>=80) Luar Biasa! 
                        @elseif($scoreValue>=60) Bagus Sekali! 
                        @else Jangan Menyerah! 
                        @endif
                    </h1>
                    <div class="inline-block bg-white/20 backdrop-blur-md px-6 py-3 rounded-full border-2 border-white/40 shadow-lg">
                        <p class="text-xl font-bold opacity-95">{{ $game->title }}</p>
                    </div>
                </div>
            </div>

            <!-- Score Section -->
            <div class="p-8">
                <div class="text-center mb-10">
                    <div class="score-entrance text-9xl font-black mb-3 float
                        @if($scoreValue>=80) bg-gradient-to-br from-green-600 to-emerald-600 
                        @elseif($scoreValue>=60) bg-gradient-to-br from-blue-600 to-indigo-600 
                        @else bg-gradient-to-br from-orange-600 to-red-600 
                        @endif bg-clip-text text-transparent drop-shadow-2xl">
                        {{ number_format($scoreValue,0) }}%
                    </div>
                    <div class="text-2xl text-gray-700 font-bold bg-gradient-to-r from-purple-100 to-pink-100 inline-block px-6 py-3 rounded-full shadow-md">
                        ✨ {{ $correctAnswers }} dari {{ $totalQuestions }} benar ✨
                    </div>
                </div>

                <!-- Stats with staggered entrance -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="card-entrance stat-card-1 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 ripple-effect border-2 border-purple-200">
                        <div class="text-6xl mb-3 animate-bounce">⭐</div>
                        <div class="text-4xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-1">+{{ $xpEarned }}</div>
                        <div class="text-sm text-gray-700 font-bold uppercase tracking-wider">XP Didapat</div>
                    </div>

                    <div class="card-entrance stat-card-2 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 ripple-effect border-2 border-blue-200">
                        @php
                            $levelIcons = [1=>'🌱',2=>'📚',3=>'⭐',4=>'🏆',5=>'👑'];
                            $icon = $levelIcons[$newLevel] ?? '⭐';
                        @endphp
                        <div class="text-6xl mb-3 celebration">{{ $icon }}</div>
                        <div class="text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-1">Level {{ $newLevel }}</div>
                        <div class="text-sm text-gray-700 font-bold uppercase tracking-wider">{{ $levelName }}</div>
                    </div>

                    <div class="card-entrance stat-card-3 bg-gradient-to-br from-yellow-50 to-amber-100 rounded-2xl p-6 text-center shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 ripple-effect border-2 border-yellow-300">
                        <div class="text-6xl mb-3 float">{{ $badge['emoji'] }}</div>
                        <div class="text-2xl font-black bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent mb-1">{{ $badge['name'] }}</div>
                        <div class="text-sm text-gray-700 font-bold uppercase tracking-wider">Badge</div>
                    </div>
                </div>

                <!-- Progress with shimmer -->
                <div class="bg-gradient-to-r from-gray-100 to-gray-50 rounded-2xl p-6 mb-10 shadow-lg border-2 border-gray-200 shimmer">
                    <div class="flex justify-between mb-3 text-sm font-bold text-gray-700">
                        <span class="flex items-center gap-2">
                            <span class="text-xl">🎯</span> Progress ke Level Berikutnya
                        </span>
                        <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent text-lg">{{ $levelInfo['progress_percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-300 rounded-full h-5 overflow-hidden shadow-inner relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                        <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-purple-600 h-5 rounded-full transition-all duration-1000 relative overflow-hidden shadow-lg" style="width: {{ $levelInfo['progress_percentage'] }}%">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-40 animate-pulse"></div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mt-3 text-center font-semibold">
                        {{ $levelInfo['current_xp'] }} / {{ $levelInfo['max_xp'] }} XP
                    </p>
                </div>

                <!-- Motivasi dengan border animasi -->
                <div class="relative bg-gradient-to-br from-purple-100 via-pink-100 to-blue-100 rounded-2xl p-8 text-center mb-10 shadow-xl overflow-hidden">
                    <div class="absolute inset-0 border-4 border-purple-300 rounded-2xl opacity-50 animate-pulse"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 via-pink-500 to-blue-500 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-pink-500 to-purple-500 animate-pulse"></div>
                    
                    <div class="relative">
                        <div class="text-4xl mb-3">📖</div>
                        <p class="text-2xl font-black text-gray-800 mb-3 italic">
                            @if($scoreValue>=90)
                                "الْمَاهِرُ بِالْقُرْآنِ مَعَ السَّفَرَةِ الْكِرَامِ الْبَرَرَةِ"
                            @elseif($scoreValue>=70)
                                "مَنْ سَلَكَ طَرِيقًا يَلْتَمِسُ فِيهِ عِلْمًا"
                            @else
                                "طَلَبُ الْعِلْمِ فَرِيضَةٌ عَلَى كُلِّ مُسْلِمٍ"
                            @endif
                        </p>
                        <p class="text-gray-700 font-semibold text-lg">
                            @if($scoreValue>=90)
                                Orang yang mahir membaca Al-Quran bersama malaikat yang mulia
                            @elseif($scoreValue>=70)
                                Barangsiapa menempuh jalan untuk mencari ilmu
                            @else
                                Menuntut ilmu adalah kewajiban bagi setiap muslim
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi dengan efek dramatis -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('santri.games.play',$game->id) }}" 
                       class="relative bg-gradient-to-r from-purple-500 via-pink-500 to-purple-600 hover:from-purple-600 hover:via-pink-600 hover:to-purple-700 text-white text-center font-black py-5 rounded-xl shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 button-pulse overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-2 text-lg">
                            🔄 Main Lagi
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </a>
                    
                    <a href="{{ route('santri.games.index') }}" 
                       class="relative bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-center font-black py-5 rounded-xl shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-2 text-lg">
                            🎮 Game Lain
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </a>
                    
                    <a href="{{ route('santri.games.index') }}" 
                       class="relative bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-center font-black py-5 rounded-xl shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-2 text-lg">
                            🏠 Dashboard
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistik dengan efek entrance -->
        <div class="mt-10 bg-white/90 backdrop-blur-xl rounded-2xl shadow-2xl p-8 card-entrance border-2 border-purple-200" style="animation-delay: 0.8s;">
            <h3 class="text-2xl font-black text-gray-800 mb-6 text-center flex items-center justify-center gap-3">
                <span class="text-3xl">📊</span> 
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Statistik Game Ini</span>
            </h3>
            <div class="grid grid-cols-3 gap-6 text-center">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 shadow-lg transform hover:scale-105 transition-all duration-300 border-2 border-purple-200">
                    <div class="text-5xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">{{ $totalQuestions }}</div>
                    <div class="text-sm text-gray-700 font-bold uppercase tracking-wider">Total Soal</div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 shadow-lg transform hover:scale-105 transition-all duration-300 border-2 border-green-200">
                    <div class="text-5xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">{{ $correctAnswers }}</div>
                    <div class="text-sm text-gray-700 font-bold uppercase tracking-wider">Benar</div>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-pink-100 rounded-xl p-6 shadow-lg transform hover:scale-105 transition-all duration-300 border-2 border-red-200">
                    <div class="text-5xl font-black bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-2">{{ $totalQuestions - $correctAnswers }}</div>
                    <div class="text-sm text-gray-700 font-bold uppercase tracking-wider">Salah</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>