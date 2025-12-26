@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; overflow: hidden;">
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="text-white fw-bold mb-2">
                            <i class="fas fa-hand-peace me-2"></i>
                            Assalamu'alaikum, {{ auth()->user()->name }}!
                        </h1>
                        <p class="text-white-50 mb-3 fs-5">Selamat datang di Sistem Pembelajaran TPQ Arabic</p>
                        <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-25 px-4 py-2 rounded-pill border border-white border-opacity-25">
                            <span class="fs-4">
                                @if(auth()->user()->isAdmin()) 🛠️
                                @elseif(auth()->user()->isTeacher()) 📚  
                                @elseif(auth()->user()->isSantri()) 🎓
                                @endif
                            </span>
                            <span class="text-white fw-semibold">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                        <div class="fs-1 animate-bounce" style="font-size: 5rem !important;">
                            @if(auth()->user()->isAdmin()) 🏆
                            @elseif(auth()->user()->isTeacher()) 👨‍🏫
                            @elseif(auth()->user()->isSantri()) 📖
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    @if(auth()->user()->isAdmin())
    <!-- Admin Statistics -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Total Users</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-10 text-success">
                        <i class="fas fa-arrow-up me-1"></i>Active
                    </span>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none small text-primary fw-semibold">
                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Total Games</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ \App\Models\Game::count() }}</div>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10">
                        <i class="fas fa-gamepad fa-2x text-success"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-10 text-success">
                        <i class="fas fa-rocket me-1"></i>Published
                    </span>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <a href="{{ route('admin.games.index') }}" class="text-decoration-none small text-success fw-semibold">
                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Total Questions</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ \App\Models\Question::count() }}</div>
                    </div>
                    <div class="icon-circle bg-info bg-opacity-10">
                        <i class="fas fa-question-circle fa-2x text-info"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-info bg-opacity-10 text-info">
                        <i class="fas fa-check me-1"></i>Available
                    </span>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <a href="{{ route('admin.questions.index') }}" class="text-decoration-none small text-info fw-semibold">
                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Total Scores</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ \App\Models\Score::count() }}</div>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10">
                        <i class="fas fa-chart-line fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-trophy me-1"></i>Recorded
                    </span>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <span class="text-decoration-none small text-warning fw-semibold">
                    Performance Data
                </span>
            </div>
        </div>
    </div>

    @elseif(auth()->user()->isTeacher())
    <!-- Teacher Statistics -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">My Games</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ \App\Models\Game::where('created_by', auth()->id())->count() }}</div>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10">
                        <i class="fas fa-gamepad fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Active Students</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ \App\Models\User::whereIn('role', ['santri_putra', 'santri_putri'])->count() }}</div>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10">
                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @elseif(auth()->user()->isSantri())
    <!-- Santri Statistics -->
    @php
        $user = auth()->user();
        $totalScores = \App\Models\Score::where('user_id', $user->id)->count();
        $averageScore = $totalScores > 0 ? \App\Models\Score::where('user_id', $user->id)->avg('score') : 0;
        $bestScore = \App\Models\Score::where('user_id', $user->id)->max('score') ?? 0;
    @endphp

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">My Level</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ $user->level ?? 1 }}</div>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10">
                        <i class="fas fa-star fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Games Played</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ $totalScores }}</div>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10">
                        <i class="fas fa-gamepad fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Average Score</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ number_format($averageScore, 1) }}%</div>
                    </div>
                    <div class="icon-circle bg-info bg-opacity-10">
                        <i class="fas fa-chart-bar fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Best Score</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ number_format($bestScore, 1) }}%</div>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10">
                        <i class="fas fa-trophy fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            @if(auth()->user()->isAdmin())
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 action-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body p-4 text-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-white bg-opacity-25 rounded-3 p-3 me-3">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">Manage Users</h5>
                                    <p class="mb-0 small opacity-75">Add, edit, or delete users</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Access Control</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('admin.games.index') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 action-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div class="card-body p-4 text-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-white bg-opacity-25 rounded-3 p-3 me-3">
                                    <i class="fas fa-gamepad fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">Manage Games</h5>
                                    <p class="mb-0 small opacity-75">Create and manage games</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Game Library</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('admin.questions.index') }}" class="text-decoration-none">
                    <div class="card border-0 h-100 action-card" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
                        <div class="card-body p-4 text-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-white bg-opacity-25 rounded-3 p-3 me-3">
                                    <i class="fas fa-question-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">Manage Questions</h5>
                                    <p class="mb-0 small opacity-75">Add questions to games</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Question Bank</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Motivational Quote -->
<div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
    <div class="card-body p-5 text-center">
        <div class="mb-3">
            <i class="fas fa-book-quran fa-4x text-primary"></i>
        </div>
        <div class="bg-white bg-opacity-75 rounded-3 py-3 px-4 mb-3 d-inline-block">
            <h3 class="mb-0 fw-bold text-primary" style="font-family: 'Traditional Arabic', serif; font-size: 1.8rem;">
                وَقُل رَّبِّ زِدْنِي عِلْمًا
            </h3>
        </div>
        <p class="lead fw-semibold text-dark mb-2">"Dan katakanlah: Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan."</p>
        <p class="text-muted mb-0">(QS. Thaha: 114)</p>
    </div>
</div>

<style>
.icon-circle {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

.action-card {
    transition: all 0.3s ease;
}

.action-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.animate-bounce {
    animation: bounce 2s infinite;
}
</style>
@endsection

