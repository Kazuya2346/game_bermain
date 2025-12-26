<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListeningQuestion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Exception;

class ListeningAudioSeeder extends Seeder
{
    private const AUDIO_FORMATS = ['webm', 'mp3', 'ogg', 'wav'];
    private const MAX_PLAY_COUNT = 2;

    private array $arabicVocabulary = [
        'low' => [
            'بَيْتٌ', 'قَلَمٌ', 'كِتَابٌ', 'بَابٌ', 'طَالِبٌ', 'مُعَلِّمٌ', 'مَدْرَسَةٌ', 'سَيَّارَةٌ', 
            'مَاءٌ', 'نَارٌ', 'وَلَدٌ', 'شَمْسٌ', 'قَمَرٌ', 'كُرْسِيٌ', 'أَسْوَدٌ', 'ذَهَبٌ', 
            'لَوْنٌ', 'يَوْمٌ', 'زَيْتٌ', 'رَجُلٌ', 'مِفْتَاحٌ', 'أَخْضَرٌ', 'أُخْتٌ', 'كُوبٌ',
            'مِلْعَقَةٌ', 'عِنَبٌ', 'حَجَرٌ', 'حَدِيدٌ', 'جَمِيلٌ', 'صَخْرٌ', 'فَاكِهَةٌ',
            'لا', 'نَعَمْ', 'مَا', 'هَذَا', 'ذَلِكَ', 'هُنَا', 'هُنَاكَ', 'مِنْ', 'إِلَى', 'فِي'
        ],
        'medium' => [
            'الْبَيْتُ الْكَبِيرُ', 'الْقَلَمُ الْأَحْمَرُ', 'الْكِتَابُ الْجَدِيدُ', 'الْبَابُ الْمَفْتُوحُ',
            'الطَّالِبُ الْمُجْتَهِدُ', 'الْمَدْرَسَةُ الْجَمِيلَةُ', 'السَّيَّارَةُ السَّرِيعَةُ', 'الْوَلَدُ الصَّغِيرُ',
            'الشَّمْسُ الْمُضِيئَةُ', 'الْقَمَرُ الْمُنِيرُ', 'الْكُرْسِيُّ الْجَدِيدُ', 'الْمَاءُ الْبَارِدُ',
            'النَّارُ الْحَارَّةُ', 'الطَّعَامُ اللَّذِيذُ', 'الْيَوْمُ الْجَمِيلُ', 'الطَّرِيقُ الطَّوِيلُ',
            'هَذَا بَيْتٌ', 'ذَلِكَ قَلَمٌ', 'الْكِتَابُ جَدِيدٌ', 'الْبَابُ مَفْتُوحٌ', 'الطَّالِبُ مُجْتَهِدٌ',
            'الْمَدْرَسَةُ جَمِيلَةٌ', 'السَّيَّارَةُ سَرِيعَةٌ', 'الْوَلَدُ صَغِيرٌ', 'الشَّمْسُ مُضِيئَةٌ'
        ],
        'hard' => [
            'ذَهَبَ الطَّالِبُ إِلَى', 'قَرَأَ الْوَلَدُ الْكِتَابَ', 'كَتَبَ التِّلْمِيذُ الدَّرْسَ',
            'الطِّفْلُ يَلْعَبُ فِي', 'الْمُعَلِّمُ يُدَرِّسُ فِي', 'الطَّالِبُ يَحْفَظُ الْقُرْآنَ',
            'الْأُسْتَاذُ يَشْرَحُ الدَّرْسَ', 'الطَّبِيبُ يُعَالِجُ الْمَرِيضَ', 'الطَّاهِي يُحَضِّرُ الطَّعَامَ',
            'الرَّجُلُ يَعْمَلُ فِي', 'الْمَرْأَةُ تَقْرَأُ الْكِتَابَ', 'الْوَلَدُ يَذْهَبُ إِلَى',
            'الطَّالِبَةُ تَدْرُسُ فِي', 'الْمُهَنْدِسُ يَبْنِي الْبَيْتَ', 'الطَّبِيعَةُ جَمِيلَةٌ فِي',
            'ذَهَبَ الطَّالِبُ إِلَى الْمَدْرَسَةِ', 'قَرَأَ الْوَلَدُ الْكِتَابَ الْجَدِيدَ',
            'الطِّفْلُ يَلْعَبُ فِي الْحَدِيقَةِ الْكَبِيرَةِ', 'الْمُعَلِّمُ يُدَرِّسُ فِي الْفَصْلِ الدِّرَاسِيِّ',
            'الطَّالِبُ يَحْفَظُ الْقُرْآنَ الْكَرِيمَ كُلَّ', 'الْأُسْتَاذُ يَشْرَحُ الدَّرْسَ لِلتَّلَامِيذِ',
            'الطَّبِيبُ يُعَالِجُ الْمَرِيضَ فِي الْمُسْتَشْفَى الْكَبِيرِ', 'الطَّاهِي يُحَضِّرُ الطَّعَامَ اللَّذِيذَ لِلضُّيُوفِ',
            'الرَّجُلُ يَعْمَلُ فِي الْمَكْتَبِ الْكَبِيرِ كُلَّ', 'الْمَرْأَةُ تَقْرَأُ الْكِتَابَ الْمُفِيدَ فِي',
            'الْوَلَدُ يَذْهَبُ إِلَى الْمَدْرَسَةِ صَبَاحًا كُلَّ', 'الطَّالِبَةُ تَدْرُسُ فِي الْجَامِعَةِ الْكَبِيرَةِ',
            'ذَهَبَ الطَّالِبُ إِلَى الْمَدْرَسَةِ صَبَاحًا', 'قَرَأَ الْوَلَدُ الْكِتَابَ الْجَدِيدَ فِي الْبَيْتِ',
            'الطِّفْلُ يَلْعَبُ فِي الْحَدِيقَةِ الْكَبِيرَةِ مَعَ', 'الْمُعَلِّمُ يُدَرِّسُ فِي الْفَصْلِ الدِّرَاسِيِّ كُلَّ',
            'الطَّالِبُ يَحْفَظُ الْقُرْآنَ الْكَرِيمَ كُلَّ يَوْمٍ', 'الْأُسْتَاذُ يَشْرَحُ الدَّرْسَ لِلتَّلَامِيذِ فِي',
            'الطَّبِيبُ يُعَالِجُ الْمَرِيضَ فِي الْمُسْتَشْفَى الْكَبِيرِ الْيَوْمَ', 'الطَّاهِي يُحَضِّرُ الطَّعَامَ اللَّذِيذَ لِلضُّيُوفِ الْكِرَامِ',
            'الرَّجُلُ يَعْمَلُ فِي الْمَكْتَبِ الْكَبِيرِ كُلَّ يَوْمٍ', 'الْمَرْأَةُ تَقْرَأُ الْكِتَابَ الْمُفِيدَ فِي الْمَكْتَبَةِ',
            'الْوَلَدُ يَذْهَبُ إِلَى الْمَدْرَسَةِ صَبَاحًا كُلَّ يَوْمٍ', 'الطَّالِبَةُ تَدْرُسُ فِي الْجَامِعَةِ الْكَبِيرَةِ بِاجْتِهَادٍ'
        ]
    ];

    private array $levelAnswerTypes = [
        'low' => 'multiple_choice',
        'medium' => 'multiple_choice', 
        'hard' => 'drag_drop_word'
    ];

    public function run(): void
    {
        $this->command->info('🎵 Memulai Import Audio Listening Questions...');
        $this->command->newLine();

        try {
            $this->truncateTable();
            $audioPath = storage_path('app/listening_audios');

            if (!$this->validateAudioPath($audioPath)) {
                return;
            }

            $stats = $this->processAudioFiles($audioPath);
            $this->displayResults($stats);

        } catch (Exception $e) {
            $this->command->error("❌ Error: {$e->getMessage()}");
            $this->command->error("Stack trace: {$e->getTraceAsString()}");
        }
    }

    private function truncateTable(): void
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            ListeningQuestion::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->command->info('✓ Tabel listening_questions berhasil dikosongkan.');
        } catch (Exception $e) {
            throw new Exception("Gagal truncate tabel: {$e->getMessage()}");
        }
    }

    private function validateAudioPath(string $path): bool
    {
        if (!File::exists($path)) {
            $this->command->error("❌ Folder '{$path}' tidak ditemukan!");
            $this->command->info("💡 Silakan buat folder 'storage/app/listening_audios' dan letakkan file audio di dalamnya.");
            return false;
        }

        $hasAudioFiles = false;
        foreach (self::AUDIO_FORMATS as $format) {
            if (!empty(glob("{$path}/*.{$format}"))) {
                $hasAudioFiles = true;
                break;
            }
        }

        if (!$hasAudioFiles) {
            $this->command->warn("⚠️  Tidak ada file audio yang ditemukan.");
            return false;
        }

        return true;
    }

    private function processAudioFiles(string $audioPath): array
    {
        $stats = [
            'imported' => 0,
            'failed' => 0,
            'skipped' => 0,
            'by_level' => ['low' => 0, 'medium' => 0, 'hard' => 0],
            'by_type' => ['multiple_choice' => 0, 'drag_drop_word' => 0, 'drag_drop_letter' => 0],
            'by_speaker' => ['latifah' => 0, 'rofi' => 0, 'unknown' => 0],
            'word_stats' => ['low' => [], 'medium' => [], 'hard' => []],
            'errors' => []
        ];

        $files = [];
        foreach (self::AUDIO_FORMATS as $format) {
            $foundFiles = glob("{$audioPath}/*.{$format}"); // ✅ DIPERBAIKI: $audioPath bukan $path
            if (is_array($foundFiles) && !empty($foundFiles)) {
                $files = array_merge($files, $foundFiles);
            }
        }
        
        if (empty($files)) {
            $this->command->warn("⚠️  Tidak ada file audio yang ditemukan.");
            return $stats;
        }

        $this->command->info("📁 Menemukan " . count($files) . " file audio");

        $progressBar = $this->command->getOutput()->createProgressBar(count($files));
        $progressBar->start();

        foreach ($files as $file) {
            try {
                $result = $this->processAudioFile($file);
                
                if ($result['status'] === 'success') {
                    $stats['imported']++;
                    $stats['by_level'][$result['level']]++;
                    $stats['by_type'][$result['answer_type']]++;
                    $stats['by_speaker'][$result['speaker']]++;
                    $stats['word_stats'][$result['level']][] = $result['word_count'];
                } elseif ($result['status'] === 'skipped') {
                    $stats['skipped']++;
                    if (isset($result['message'])) {
                        $stats['errors'][] = $result['message'];
                    }
                } else {
                    $stats['failed']++;
                    if (isset($result['message'])) {
                        $stats['errors'][] = $result['message'];
                    }
                }
            } catch (Exception $e) {
                $stats['failed']++;
                $stats['errors'][] = basename($file) . ": " . $e->getMessage();
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->newLine(2);

        return $stats;
    }

    private function processAudioFile(string $filePath): array
    {
        $fileName = basename($filePath);

        if (!preg_match('/^(?:[^_]+_)?([^\d][^.]+)\.(webm|mp3|ogg|wav)$/u', $fileName, $matches)) {
            return [
                'status' => 'skipped',
                'message' => "Format nama file tidak sesuai: {$fileName}. Format: speaker_text.ext atau text.ext"
            ];
        }

        $arabicText = trim($matches[1]);
        $arabicText = preg_replace('/[_\-]/', ' ', $arabicText);
        $arabicText = trim($arabicText);

        $wordCount = $this->countWordsFixed($arabicText);

        if ($wordCount === 0) {
            return [
                'status' => 'skipped',
                'message' => "Teks Arab kosong: {$fileName}"
            ];
        }

        $level = $this->determineLevel($wordCount, $arabicText);
        $answerType = $this->levelAnswerTypes[$level];

        $speaker = 'unknown';
        $lowerFileName = strtolower($fileName);
        if (str_starts_with($lowerFileName, 'latifah')) {
            $speaker = 'latifah';
        } elseif (str_starts_with($lowerFileName, 'rofi')) {
            $speaker = 'rofi';
        }

        try {
            $audioData = @file_get_contents($filePath);
            
            if ($audioData === false) {
                throw new Exception("Tidak dapat membaca file audio");
            }
            
            $audioSize = filesize($filePath);
            
            if ($audioSize === false || $audioSize === 0) {
                throw new Exception("File kosong atau corrupt");
            }

        } catch (Exception $e) {
            return [
                'status' => 'failed',
                'message' => "Error membaca {$fileName}: {$e->getMessage()}"
            ];
        }

        if ($audioSize > 5 * 1024 * 1024) {
            return [
                'status' => 'skipped',
                'message' => "File terlalu besar (>5MB): {$fileName}"
            ];
        }

        $options = [];
        
        if ($answerType === 'multiple_choice') {
            $options = $this->generateAnswerOptions($arabicText, $level);
            
            if (count(array_unique($options)) < 4) {
                return [
                    'status' => 'failed',
                    'message' => "Gagal generate opsi unik untuk: {$fileName}"
                ];
            }
        } else {
            $options = ['', '', '', ''];
        }

        ListeningQuestion::create([
            'level' => $level,
            'speaker' => $speaker,
            'audio_data' => $audioData,
            'audio_mime_type' => $this->getMimeType($filePath),
            'audio_size' => $audioSize,
            'word_count' => $wordCount,
            'question_text' => $this->getQuestionText($level, $answerType),
            'correct_answer' => $arabicText,
            'answer_type' => $answerType,
            'option_a' => $options[0] ?? '',
            'option_b' => $options[1] ?? '',
            'option_c' => $options[2] ?? '',
            'option_d' => $options[3] ?? '',
            'exp_reward' => $this->getExpReward($level),
            'play_count_limit' => self::MAX_PLAY_COUNT
        ]);

        return [
            'status' => 'success',
            'level' => $level,
            'answer_type' => $answerType,
            'speaker' => $speaker,
            'word_count' => $wordCount
        ];
    }

    private function countWordsFixed(string $text): int
    {
        $text = preg_replace('/\s+/u', ' ', trim($text));
        
        if (empty($text)) {
            return 0;
        }

        $words = explode(' ', $text);
        $nonEmptyWords = array_filter($words, function($word) {
            return $word !== '' && $word !== ' ';
        });

        return count($nonEmptyWords);
    }

    private function determineLevel(int $wordCount, string $text): string
    {
        if ($wordCount >= 3 && $wordCount <= 4) {
            return 'hard';
        }
        
        if ($wordCount >= 5) {
            return 'hard';
        }

        return match(true) {
            $wordCount === 1 => 'low',
            $wordCount === 2 => 'medium',
            $wordCount >= 3 => 'hard',
            default => 'low'
        };
    }

    private function generateAnswerOptions(string $correctAnswer, string $level): array
    {
        $attempts = 0;
        $maxAttempts = 10;
        
        while ($attempts < $maxAttempts) {
            $distractors = $this->generateDistractors($correctAnswer, $level);
            
            $validDistractors = array_filter($distractors, function($d) use ($correctAnswer) {
                return $d !== $correctAnswer && 
                       $this->isValidArabicText($d) && 
                       $this->hasHarakat($d) &&
                       !empty(trim($d));
            });
            
            $validDistractors = array_values(array_unique($validDistractors));
            
            if (count($validDistractors) >= 3) {
                $validDistractors = array_slice($validDistractors, 0, 3);
                $allOptions = array_merge([$correctAnswer], $validDistractors);
                $uniqueOptions = array_values(array_unique($allOptions));
                
                if (count($uniqueOptions) === 4) {
                    shuffle($uniqueOptions);
                    return $uniqueOptions;
                }
            }
            
            $attempts++;
        }
        
        return $this->generateFallbackOptions($correctAnswer, $level);
    }
    
    private function hasHarakat(string $text): bool
    {
        $harakatChars = ['ً', 'ٌ', 'ٍ', 'َ', 'ُ', 'ِ', 'ْ', 'ّ', 'ٓ', 'ٰ'];
        
        foreach ($harakatChars as $harakat) {
            if (mb_strpos($text, $harakat) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    private function generateFallbackOptions(string $correctAnswer, string $level): array
    {
        $vocab = $this->arabicVocabulary[$level] ?? $this->arabicVocabulary['low'];
        $availableVocab = array_filter($vocab, function($v) use ($correctAnswer) {
            return $v !== $correctAnswer;
        });
        
        shuffle($availableVocab);
        $distractors = array_slice($availableVocab, 0, 3);
        $allOptions = array_merge([$correctAnswer], $distractors);
        shuffle($allOptions);
        
        return $allOptions;
    }

    private function generateDistractors(string $correctAnswer, string $level): array
    {
        $distractors = [];

        $dist1 = $this->alterHarakat($correctAnswer, 'light');
        if ($dist1 !== $correctAnswer && $this->hasHarakat($dist1)) {
            $distractors[] = $dist1;
        }
        
        $dist2 = $this->alterHarakat($correctAnswer, 'medium');
        if ($dist2 !== $correctAnswer && $this->hasHarakat($dist2)) {
            $distractors[] = $dist2;
        }

        if ($level !== 'low') {
            $dist3 = $this->alterSimilarWord($correctAnswer);
            if ($dist3 !== $correctAnswer && $this->hasHarakat($dist3)) {
                $distractors[] = $dist3;
            }
        }

        $dist4 = $this->alterSimilarLetters($correctAnswer, 'first');
        if ($dist4 !== $correctAnswer && $this->hasHarakat($dist4)) {
            $distractors[] = $dist4;
        }

        if (isset($this->arabicVocabulary[$level])) {
            $vocab = $this->arabicVocabulary[$level];
            shuffle($vocab);
            
            foreach ($vocab as $word) {
                if ($word !== $correctAnswer && 
                    !in_array($word, $distractors) && 
                    $this->hasHarakat($word)) {
                    $distractors[] = $word;
                    
                    if (count($distractors) >= 5) break;
                }
            }
        }

        return array_values(array_unique($distractors));
    }

    private function alterHarakat(string $word, string $intensity = 'light'): string
    {
        $replacements = [
            'َ' => ['ُ', 'ِ'],
            'ُ' => ['َ', 'ِ'],
            'ِ' => ['َ', 'ُ'],
            'ْ' => ['َ', 'ُ', 'ِ'],
            'ً' => ['ٌ', 'ٍ'],
            'ٌ' => ['ً', 'ٍ'],
            'ٍ' => ['ً', 'ٌ'],
        ];

        $result = $word;
        $changeCount = match($intensity) {
            'light' => 1,
            'medium' => 2,
            'heavy' => 3,
            default => 1
        };

        $chars = preg_split('//u', $result, -1, PREG_SPLIT_NO_EMPTY);
        if (!$chars) return $word;

        $changedIndices = [];
        $attempts = 0;
        $maxAttempts = 20;

        while (count($changedIndices) < $changeCount && $attempts < $maxAttempts) {
            $i = rand(0, count($chars) - 1);
            
            if (in_array($i, $changedIndices)) {
                $attempts++;
                continue;
            }

            $char = $chars[$i];
            if (isset($replacements[$char])) {
                $newChar = $replacements[$char][array_rand($replacements[$char])];
                $chars[$i] = $newChar;
                $changedIndices[] = $i;
            }
            
            $attempts++;
        }

        return implode('', $chars);
    }

    private function alterSimilarWord(string $phrase): string
    {
        $words = preg_split('/\s+/', $phrase);
        if (count($words) < 2) {
            return $phrase;
        }

        $swaps = [
            'كِتَاب' => 'قَلَم',
            'وَلَد' => 'بِنْت',
            'رَجُل' => 'امْرَأَة',
            'طَالِب' => 'مُعَلِّم',
            'بَيْت' => 'مَدْرَسَة',
            'كَبِير' => 'صَغِير',
            'جَدِيد' => 'قَدِيم',
            'جَمِيل' => 'قَبِيح',
        ];

        $changed = false;
        foreach ($words as &$word) {
            foreach ($swaps as $from => $to) {
                if (mb_strpos($word, $from) !== false) {
                    $word = str_replace($from, $to, $word);
                    $changed = true;
                    break 2;
                }
            }
        }

        return $changed ? implode(' ', $words) : $phrase;
    }

    private function alterSimilarLetters(string $text, string $variant = 'first'): string
    {
        $similarLettersGroups = [
            'first' => [
                'ت' => 'ط', 'ط' => 'ت',
                'د' => 'ض', 'ض' => 'د',
                'س' => 'ص', 'ص' => 'س',
                'ذ' => 'ظ', 'ظ' => 'ذ',
            ],
            'second' => [
                'ه' => 'ح', 'ح' => 'ه',
                'ع' => 'غ', 'غ' => 'ع',
                'ك' => 'ق', 'ق' => 'ك',
            ]
        ];

        $similarLetters = $similarLettersGroups[$variant] ?? $similarLettersGroups['first'];

        foreach ($similarLetters as $from => $to) {
            $pos = mb_strpos($text, $from);
            if ($pos !== false) {
                return mb_substr($text, 0, $pos) . $to . mb_substr($text, $pos + 1);
            }
        }

        return $text;
    }

    private function isValidArabicText(string $text): bool
    {
        return preg_match('/^[\p{Arabic}\sًٌٍَُِّْٰٓ]+$/u', $text) === 1;
    }

    private function getQuestionText(string $level, string $answerType): string
    {
        if ($answerType === 'drag_drop_word') {
            return 'رَتِّبِ الْكَلِمَاتِ لِتُكَوِّنَ جُمْلَةً صَحِيحَةً';
        }
        
        return match($level) {
            'low' => 'ما الكَلِمَةُ الَّتِي سَمِعْتَهَا؟',
            'medium' => 'ما الكَلِمَتَانِ اللَّتَانِ سَمِعْتَهُمَا؟',
            'hard' => 'ما الجُمْلَةُ الَّتِي سَمِعْتَهَا؟',
            default => 'مَاذَا سَمِعْتَ؟'
        };
    }

    private function getExpReward(string $level): int
    {
        return match($level) {
            'low' => 10,
            'medium' => 15,
            'hard' => 20,
            default => 10
        };
    }

    private function getMimeType(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return match($extension) {
            'webm' => 'audio/webm',
            'mp3' => 'audio/mpeg',
            'ogg' => 'audio/ogg',
            'wav' => 'audio/wav',
            default => 'audio/webm'
        };
    }

    private function displayResults(array $stats): void
    {
        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('           🎉 HASIL IMPORT AUDIO');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->newLine();

        $this->command->table(
            ['Status', 'Jumlah'],
            [
                ['✅ Berhasil', $stats['imported']],
                ['⏭️  Dilewati', $stats['skipped']],
                ['❌ Gagal', $stats['failed']],
            ]
        );

        if ($stats['imported'] > 0) {
            $wordStats = [];
            foreach (['low', 'medium', 'hard'] as $level) {
                $wordCounts = $stats['word_stats'][$level] ?? [];
                if (!empty($wordCounts)) {
                    $wordStats[$level] = [
                        'min' => min($wordCounts),
                        'max' => max($wordCounts),
                        'avg' => round(array_sum($wordCounts) / count($wordCounts), 1),
                        'total' => count($wordCounts)
                    ];
                }
            }

            $this->command->newLine();
            $this->command->info('📊 Distribusi per Level:');
            $this->command->table(
                ['Level', 'Jumlah Soal', 'Tipe Soal', 'Kata Min', 'Kata Max', 'Kata Rata2', 'EXP'],
                [
                    [
                        'Low', 
                        $stats['by_level']['low'], 
                        'Multiple Choice',
                        $wordStats['low']['min'] ?? '-',
                        $wordStats['low']['max'] ?? '-',
                        $wordStats['low']['avg'] ?? '-',
                        '10 XP'
                    ],
                    [
                        'Medium', 
                        $stats['by_level']['medium'], 
                        'Multiple Choice',
                        $wordStats['medium']['min'] ?? '-',
                        $wordStats['medium']['max'] ?? '-',
                        $wordStats['medium']['avg'] ?? '-',
                        '15 XP'
                    ],
                    [
                        'Hard', 
                        $stats['by_level']['hard'], 
                        'Drag & Drop',
                        $wordStats['hard']['min'] ?? '-',
                        $wordStats['hard']['max'] ?? '-',
                        $wordStats['hard']['avg'] ?? '-',
                        '20 XP'
                    ],
                ]
            );

            $this->command->newLine();
            $this->command->info('🎯 Distribusi per Tipe Soal:');
            $this->command->table(
                ['Tipe Soal', 'Jumlah'],
                [
                    ['Multiple Choice', $stats['by_type']['multiple_choice']],
                    ['Drag & Drop Word', $stats['by_type']['drag_drop_word']],
                ]
            );

            $this->command->newLine();
            $this->command->info('🎤 Distribusi per Speaker:');
            $this->command->table(
                ['Speaker', 'Jumlah'],
                [
                    ['Latifah', $stats['by_speaker']['latifah']],
                    ['Rofi', $stats['by_speaker']['rofi']],
                    ['Unknown', $stats['by_speaker']['unknown']],
                ]
            );
        }

        if (!empty($stats['errors'])) {
            $this->command->newLine();
            $this->command->warn('⚠️  Terjadi beberapa kesalahan:');
            foreach (array_slice($stats['errors'], 0, 10) as $error) {
                $this->command->line("   • {$error}");
            }
            if (count($stats['errors']) > 10) {
                $this->command->line("   ... dan " . (count($stats['errors']) - 10) . " error lainnya");
            }
        }

        $this->command->newLine();
        $this->command->info('✨ PERBAIKAN YANG DITERAPKAN:');
        $this->command->info('  ✅ Perbaikan variabel $audioPath di processAudioFiles()');
        $this->command->info('  ✅ Logika penghitungan kata yang benar (termasuk 1 huruf)');
        $this->command->info('  ✅ Level Hard menggunakan Drag & Drop');
        $this->command->info('═══════════════════════════════════════════════');
    }
}