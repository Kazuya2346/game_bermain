<?php

namespace App\Http\Controllers;

use App\Services\ListeningGameService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controller untuk mengelola game listening
 * 
 * Menghandle:
 * - View rendering (index, play, result)
 * - API endpoints untuk game flow
 * - Error handling dan logging
 * 
 * FIXED VERSION - Menggabungkan semua perbaikan
 */
class ListeningGameController extends Controller
{
    /**
     * Inject ListeningGameService
     */
    public function __construct(
        protected ListeningGameService $gameService
    ) {
        // Middleware auth sudah di-apply di route
    }

    // ================================================================
    // VIEW METHODS
    // ================================================================

    /**
     * Tampilkan halaman pilih level game
     * 
     * @return View
     */
    public function index(): View
    {
        $levels = [
            'low' => [
                'name' => 'مُبْتَدِئ',
                'name_id' => 'Pemula',
                'description' => 'Soal mudah dengan pilihan ganda',
                'icon' => '🌱',
                'color' => 'green',
            ],
            'medium' => [
                'name' => 'مُتَوَسِّط',
                'name_id' => 'Menengah',
                'description' => 'Soal sedang dengan pilihan ganda',
                'icon' => '📚',
                'color' => 'blue',
            ],
            'hard' => [
                'name' => 'صَعْب',
                'name_id' => 'Sulit',
                'description' => 'Tantangan tingkat lanjut: susun beberapa kata (3+) menjadi kalimat yang benar',
                'icon' => '🎯',
                'color' => 'orange',
            ],
        ];

        return view('santri.listening.index', compact('levels'));
    }

    /**
     * Tampilkan halaman bermain game
     * 
     * @return View
     */
    public function play(): View
    {
        return view('santri.listening.play');
    }

    /**
     * Tampilkan halaman hasil game
     * 
     * @return View
     */
    public function result(): View
    {
        return view('santri.listening.result');
    }

    // ================================================================
    // API ENDPOINTS
    // ================================================================

    /**
     * API: Mulai sesi game baru
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function startGame(Request $request): JsonResponse
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'level' => [
                    'required',
                    'string',
                    'in:low,medium,hard',
                ],
            ], [
                'level.required' => 'Level game harus dipilih.',
                'level.in' => 'Level game tidak valid.',
            ]);

            // Mulai game
            $result = $this->gameService->startNewGame($validated['level']);

            // Log aktivitas
            Log::info('Game dimulai', [
                'user_id' => auth()->id(),
                'level' => $validated['level'],
            ]);

            return $this->successResponse($result, 'Game berhasil dimulai');

        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal memulai game');
        }
    }

    /**
     * API: Submit jawaban user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function submitAnswer(Request $request): JsonResponse
    {
        try {
            // Validasi input dengan perbaikan validasi array elements
            $validated = $request->validate([
                'user_answer' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Validasi: harus string atau array
                        if (!is_string($value) && !is_array($value)) {
                            $fail('Format jawaban tidak valid.');
                        }
                        
                        // FIXED: Validasi elemen array
                        if (is_array($value)) {
                            foreach ($value as $item) {
                                if (!is_string($item)) {
                                    $fail('Setiap elemen jawaban harus berupa string.');
                                    break;
                                }
                            }
                        }
                    },
                ],
            ], [
                'user_answer.required' => 'Jawaban tidak boleh kosong.',
            ]);

            // Submit jawaban
            $result = $this->gameService->submitAnswer($validated['user_answer']);

            // Log jika jawaban benar
            if ($result['status'] === 'correct') {
                Log::info('Jawaban benar', [
                    'user_id' => auth()->id(),
                    'points' => $result['score']['points'] ?? 0,
                ]);
            }

            return $this->successResponse($result);

        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal memproses jawaban');
        }
    }

    /**
     * API: Ambil soal berikutnya
     * 
     * @return JsonResponse
     */
    public function getNextQuestion(): JsonResponse
    {
        try {
            $result = $this->gameService->getNextQuestion();

            // Log jika game selesai
            if ($result['status'] === 'completed') {
                Log::info('Game selesai', [
                    'user_id' => auth()->id(),
                    'total_score' => $result['summary']['total_score'] ?? 0,
                    'accuracy' => $result['summary']['accuracy'] ?? 0,
                ]);
            }

            return $this->successResponse($result);

        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal mengambil soal berikutnya');
        }
    }

    /**
     * API: Gunakan hint
     * 
     * @return JsonResponse
     */
    public function useHint(): JsonResponse
    {
        try {
            $result = $this->gameService->getHint();

            Log::info('Hint digunakan', [
                'user_id' => auth()->id(),
            ]);

            return $this->successResponse($result, 'Hint berhasil diambil');

        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal mengambil hint');
        }
    }

    /**
     * API: Batalkan game
     * 
     * @return JsonResponse
     */
    public function cancelGame(): JsonResponse
    {
        try {
            $result = $this->gameService->cancelGame();

            Log::info('Game dibatalkan', [
                'user_id' => auth()->id(),
            ]);

            return $this->successResponse($result, 'Game berhasil dibatalkan');

        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal membatalkan game');
        }
    }

    /**
     * API: Pause game (simpan progress)
     * 
     * @return JsonResponse
     */
    public function pauseGame(): JsonResponse
    {
        try {
            $result = $this->gameService->pauseGame();

            Log::info('Game di-pause', [
                'user_id' => auth()->id(),
            ]);

            return $this->successResponse($result, 'Game berhasil di-pause');

        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal pause game');
        }
    }

    /**
     * API: Resume game yang di-pause
     * 
     * @return JsonResponse
     */
    public function resumeGame(): JsonResponse
    {
        try {
            $result = $this->gameService->resumeGame();

            Log::info('Game di-resume', [
                'user_id' => auth()->id(),
            ]);

            return $this->successResponse($result, 'Game berhasil dilanjutkan');

        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal melanjutkan game');
        }
    }

    /**
     * API: Dapatkan statistik game user
     * 
     * @return JsonResponse
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $user = auth()->user();
            
            // FIXED: Check if fields exist before accessing
            $stats = [
                'total_games' => $user->game_sessions()->count(),
                'total_points' => $user->total_points ?? 0,
                'total_exp' => $user->total_exp ?? 0,
                'accuracy' => $this->calculateUserAccuracy(),
                'favorite_level' => $this->getUserFavoriteLevel(),
            ];

            return $this->successResponse($stats);

        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal mengambil statistik');
        }
    }

    // ================================================================
    // HELPER METHODS
    // ================================================================

    /**
     * Success response helper
     * 
     * @param mixed $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse(
        mixed $data,
        ?string $message = null,
        int $statusCode = 200
    ): JsonResponse {
        $response = [
            'success' => true,
            'data' => $data,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Error response helper
     * 
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @return JsonResponse
     */
    protected function errorResponse(
        string $message,
        int $statusCode = 500,
        array $errors = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Validation error response helper
     * 
     * @param ValidationException $exception
     * @return JsonResponse
     */
    protected function validationErrorResponse(ValidationException $exception): JsonResponse
    {
        return $this->errorResponse(
            'Validasi gagal',
            422,
            $exception->errors()
        );
    }

    /**
     * Handle exception dan return error response
     * 
     * @param \Exception $exception
     * @param string $message
     * @return JsonResponse
     */
    protected function handleException(\Exception $exception, string $message): JsonResponse
    {
        // Log error detail
        Log::error($message, [
            'user_id' => auth()->id(),
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        // Jangan expose error detail di production
        $errorMessage = app()->isProduction()
            ? $message
            : $message . ': ' . $exception->getMessage();

        return $this->errorResponse($errorMessage, 500);
    }

    /**
     * Hitung akurasi user
     * 
     * FIXED: Added safe checks untuk field yang mungkin tidak ada
     * 
     * @return float
     */
    protected function calculateUserAccuracy(): float
    {
        $user = auth()->user();
        $totalQuestions = $user->total_questions ?? 0;
        $correctAnswers = $user->correct_answers ?? 0;

        if ($totalQuestions === 0) {
            return 0;
        }

        return round(($correctAnswers / $totalQuestions) * 100, 2);
    }

    /**
     * Dapatkan level favorit user
     * 
     * @return string|null
     */
    protected function getUserFavoriteLevel(): ?string
    {
        return auth()->user()
            ->game_sessions()
            ->selectRaw('level_type, COUNT(*) as count')
            ->groupBy('level_type')
            ->orderByDesc('count')
            ->value('level_type');
    }
}