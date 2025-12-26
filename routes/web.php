<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UstadzController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Auth\RegisterSantriController;
use App\Http\Controllers\ListeningGameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| Registrasi Santri Routes (Public - Sebelum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register-santri', [RegisterSantriController::class, 'create'])->name('register.santri');
    Route::post('/register-santri', [RegisterSantriController::class, 'store'])->name('register.santri.store');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard Route (Auto Redirect berdasarkan Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    
    return match(true) {
        $user->isAdmin() => redirect()->route('admin.dashboard'),
        $user->isTeacher() => redirect()->route('ustadz.dashboard'),
        $user->isSantri() => redirect()->route('santri.dashboard'),
        default => view('dashboard')
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    
    // Photo Management Routes
    Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
    Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.delete');
    
    // Password Update Route
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function() {
        return view('dashboard', [
            'totalUsers' => \App\Models\User::count(),
            'totalGames' => \App\Models\Game::count(),
            'totalQuestions' => \App\Models\Question::count(),
            'totalScores' => \App\Models\Score::count()
        ]);
    })->name('dashboard');
    
    // Resource Controllers
    Route::resource('users', UserController::class);
    Route::resource('games', GameController::class);
    Route::resource('questions', QuestionController::class);
    
    // Game Status Toggle
    Route::post('/games/{game}/status', [GameController::class, 'toggleStatus'])->name('games.toggleStatus');
});

/*
|--------------------------------------------------------------------------
| Ustadz/Ustadzah Routes (Teacher)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'teacher'])->prefix('ustadz')->name('ustadz.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [UstadzController::class, 'dashboard'])->name('dashboard');
    
    // Games Management
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/', [UstadzController::class, 'games'])->name('index');
        Route::get('/create', [UstadzController::class, 'createGame'])->name('create');
        Route::post('/', [UstadzController::class, 'storeGame'])->name('store');
        Route::get('/{id}', [UstadzController::class, 'showGame'])->name('show');
        Route::get('/{id}/edit', [UstadzController::class, 'editGame'])->name('edit');
        Route::put('/{id}', [UstadzController::class, 'updateGame'])->name('update');
        Route::delete('/{id}', [UstadzController::class, 'destroyGame'])->name('destroy');
        Route::post('/{id}/status', [UstadzController::class, 'toggleStatus'])->name('toggleStatus');
        
        // Questions for specific game
        Route::prefix('/{game_id}/questions')->name('questions.')->group(function () {
            Route::get('/', [UstadzController::class, 'questions'])->name('index');
            Route::get('/create', [UstadzController::class, 'createQuestion'])->name('create');
            Route::post('/', [UstadzController::class, 'storeQuestion'])->name('store');
            Route::get('/{question_id}/edit', [UstadzController::class, 'editQuestion'])->name('edit');
            Route::put('/{question_id}', [UstadzController::class, 'updateQuestion'])->name('update');
            Route::delete('/{question_id}', [UstadzController::class, 'destroyQuestion'])->name('destroy');
        });
    });
    
    // Scores Management
    Route::prefix('scores')->name('scores.')->group(function () {
        Route::get('/', [UstadzController::class, 'scores'])->name('index');
        Route::get('/game/{game_id}', [UstadzController::class, 'gameScores'])->name('game');
        Route::get('/game/{game_id}/matrix', [UstadzController::class, 'reviewMatrix'])->name('matrix');
        Route::get('/{score_id}/detail', [UstadzController::class, 'scoreDetail'])->name('detail');
    });
});

/*
|--------------------------------------------------------------------------
| Santri Routes (Students)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'santri'])->prefix('santri')->name('santri.')->group(function () {
    
    // Dashboard & Main Pages
    Route::get('/dashboard', [SantriController::class, 'dashboard'])->name('dashboard');
    Route::get('/scores', [SantriController::class, 'scores'])->name('scores');
    Route::get('/leaderboard', [SantriController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/profile', [SantriController::class, 'profile'])->name('profile');
    
    // General Games
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/', [SantriController::class, 'games'])->name('index');
        Route::get('/{id}/play', [SantriController::class, 'playGame'])->name('play');
        Route::post('/{id}/submit', [SantriController::class, 'submitGame'])->name('submit');
        Route::get('/{id}/result', [SantriController::class, 'gameResult'])->name('result');
    });
    
    // Survival Quiz Game
    Route::prefix('survival')->name('survival.')->group(function () {
        Route::get('/play', [SantriController::class, 'survivalGamePlay'])->name('play');
        Route::post('/submit', [SantriController::class, 'survivalGameSubmit'])->name('submit');
    });
    
    // Sentence Builder Game
    Route::prefix('sentence-builder')->name('sentence-builder.')->group(function () {
        Route::get('/play', [SantriController::class, 'playSentenceBuilder'])->name('play');
        Route::post('/check', [SantriController::class, 'checkSentenceBuilder'])->name('check');
        Route::post('/submit', [SantriController::class, 'submitSentenceBuilder'])->name('submit');
        Route::get('/result', [SantriController::class, 'resultSentenceBuilder'])->name('result');
    });
    
    // ==================== LISTENING GAME - NEW IMPLEMENTATION ====================
    // Listening Game - Simplified Implementation
    Route::prefix('listening')->name('listening.')->group(function () {
        // View Routes
        Route::get('/', [ListeningGameController::class, 'index'])->name('index');
        Route::get('/play', [ListeningGameController::class, 'play'])->name('play');
        Route::get('/result', [ListeningGameController::class, 'result'])->name('result');
        
        // API Routes untuk Game Flow
        Route::prefix('api')->name('api.')->group(function () {
            Route::post('/start', [ListeningGameController::class, 'startGame'])->name('start');
            Route::post('/submit', [ListeningGameController::class, 'submitAnswer'])->name('submit');
            Route::post('/next', [ListeningGameController::class, 'getNextQuestion'])->name('next');
            Route::post('/hint', [ListeningGameController::class, 'useHint'])->name('hint');
            Route::post('/cancel', [ListeningGameController::class, 'cancelGame'])->name('cancel');
            Route::get('/session', [ListeningGameController::class, 'checkSession'])->name('session');
        });
    });
});

/*
|--------------------------------------------------------------------------
| API Routes (Optional - untuk AJAX/Fetch requests)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->prefix('api/v1')->name('api.v1.')->group(function () {
    
});