<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaySoQuyLuatController extends Controller
{
    private function generateQuestion($level)
    {
        $questions = [
            // Cấp độ 1: Quy luật cộng/trừ đơn giản
            1 => [
                [
                    'sequence' => [
                        ['numerator' => 1, 'denominator' => 2],
                        ['numerator' => 2, 'denominator' => 4],
                        ['numerator' => 3, 'denominator' => 6],
                        ['numerator' => 4, 'denominator' => 8],
                    ],
                    'answer' => ['numerator' => 5, 'denominator' => 10]
                ],
                [
                    'sequence' => [
                        ['numerator' => 2, 'denominator' => 3],
                        ['numerator' => 4, 'denominator' => 6],
                        ['numerator' => 6, 'denominator' => 9],
                        ['numerator' => 8, 'denominator' => 12],
                    ],
                    'answer' => ['numerator' => 10, 'denominator' => 15]
                ]
            ],
            // Cấp độ 2: Quy luật nhân/chia
            2 => [
                [
                    'sequence' => [
                        ['numerator' => 1, 'denominator' => 3],
                        ['numerator' => 2, 'denominator' => 6],
                        ['numerator' => 4, 'denominator' => 12],
                        ['numerator' => 8, 'denominator' => 24],
                    ],
                    'answer' => ['numerator' => 16, 'denominator' => 48]
                ],
                [
                    'sequence' => [
                        ['numerator' => 3, 'denominator' => 4],
                        ['numerator' => 6, 'denominator' => 8],
                        ['numerator' => 12, 'denominator' => 16],
                        ['numerator' => 24, 'denominator' => 32],
                    ],
                    'answer' => ['numerator' => 48, 'denominator' => 64]
                ]
            ],
            // Cấp độ 3: Quy luật phức tạp hơn
            3 => [
                [
                    'sequence' => [
                        ['numerator' => 1, 'denominator' => 2],
                        ['numerator' => 3, 'denominator' => 4],
                        ['numerator' => 5, 'denominator' => 6],
                        ['numerator' => 7, 'denominator' => 8],
                    ],
                    'answer' => ['numerator' => 9, 'denominator' => 10]
                ],
                [
                    'sequence' => [
                        ['numerator' => 2, 'denominator' => 5],
                        ['numerator' => 4, 'denominator' => 7],
                        ['numerator' => 6, 'denominator' => 9],
                        ['numerator' => 8, 'denominator' => 11],
                    ],
                    'answer' => ['numerator' => 10, 'denominator' => 13]
                ]
            ],
            // Cấp độ 4: Quy luật nâng cao
            4 => [
                [
                    'sequence' => [
                        ['numerator' => 1, 'denominator' => 3],
                        ['numerator' => 3, 'denominator' => 5],
                        ['numerator' => 5, 'denominator' => 7],
                        ['numerator' => 7, 'denominator' => 9],
                    ],
                    'answer' => ['numerator' => 9, 'denominator' => 11]
                ],
                [
                    'sequence' => [
                        ['numerator' => 2, 'denominator' => 3],
                        ['numerator' => 5, 'denominator' => 7],
                        ['numerator' => 8, 'denominator' => 11],
                        ['numerator' => 11, 'denominator' => 15],
                    ],
                    'answer' => ['numerator' => 14, 'denominator' => 19]
                ]
            ],
            // Cấp độ 5: Quy luật phức tạp nhất
            5 => [
                [
                    'sequence' => [
                        ['numerator' => 1, 'denominator' => 2],
                        ['numerator' => 2, 'denominator' => 5],
                        ['numerator' => 3, 'denominator' => 10],
                        ['numerator' => 4, 'denominator' => 17],
                    ],
                    'answer' => ['numerator' => 5, 'denominator' => 26]
                ],
                [
                    'sequence' => [
                        ['numerator' => 1, 'denominator' => 1],
                        ['numerator' => 3, 'denominator' => 2],
                        ['numerator' => 5, 'denominator' => 3],
                        ['numerator' => 7, 'denominator' => 4],
                    ],
                    'answer' => ['numerator' => 9, 'denominator' => 5]
                ]
            ]
        ];

        // Lấy ngẫu nhiên một câu hỏi từ cấp độ hiện tại
        $levelQuestions = $questions[$level];
        $randomQuestion = $levelQuestions[array_rand($levelQuestions)];
        
        return [
            'level' => $level,
            'sequence' => $randomQuestion['sequence'],
            'answer' => $randomQuestion['answer']
        ];
    }

    public function patternGame(Request $request)
    {
        // Lấy cấp độ từ session hoặc mặc định là 1
        $level = session('pattern_level', 1);
        
        // Tạo câu hỏi cho cấp độ hiện tại
        $question = $this->generateQuestion($level);

        return view('games.lop4.day_so_quy_luat.pattern', compact('question'));
    }

    public function checkAnswer(Request $request)
    {
        $answer = $request->input('answer');
        $correctAnswer = $request->input('correct_answer');
        $currentLevel = session('pattern_level', 1);

        $isCorrect = $answer['numerator'] === $correctAnswer['numerator'] && 
                    $answer['denominator'] === $correctAnswer['denominator'];

        if ($isCorrect) {
            // Tăng cấp độ nếu chưa đạt cấp độ tối đa
            if ($currentLevel < 5) {
                session(['pattern_level' => $currentLevel + 1]);
            }
        }

        return response()->json([
            'correct' => $isCorrect,
            'next_level' => $isCorrect && $currentLevel < 5
        ]);
    }

    
} 