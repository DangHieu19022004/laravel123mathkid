<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KhamPhaPhanSoController extends Controller
{
    public function index() {
        return view('games.lop4.kham_pha_phan_so.kham_pha_phan_so');
    }
    // Apple Game Methods
    public function appleGame()
    {
        $level = session('apple_level', 1);
        $question = $this->generateAppleQuestion($level);
        return view('games.lop4.phanso.apple', compact('question'));
    }

    private function generateAppleQuestion($level)
    {
        $questions = [
            1 => ['apples' => 4, 'students' => 2],  // Level 1: 4 apples for 2 students
            2 => ['apples' => 6, 'students' => 3],  // Level 2: 6 apples for 3 students
            3 => ['apples' => 8, 'students' => 4],  // Level 3: 8 apples for 4 students
            4 => ['apples' => 10, 'students' => 5], // Level 4: 10 apples for 5 students
            5 => ['apples' => 12, 'students' => 6]  // Level 5: 12 apples for 6 students
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkAppleAnswer(Request $request)
    {
        $level = session('apple_level', 1);
        $question = $this->generateAppleQuestion($level);
        
        $groupCounts = json_decode($request->input('group_counts'), true);
        $applesPerGroup = $question['apples'] / $question['students'];
        
        // Kiểm tra xem mỗi nhóm có đúng số táo không
        $correct = true;
        foreach ($groupCounts as $count) {
            if ($count != $applesPerGroup) {
                $correct = false;
                break;
            }
        }
        
        if ($correct && $level < 5) {
            session(['apple_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    
    // Balance Game Methods
    public function balanceGame()
    {
        $level = session('balance_level', 1);
        $question = $this->generateBalanceQuestion($level);
        return view('games.lop4.phanso.balance', compact('question'));
    }

    private function generateBalanceQuestion($level)
    {
        $questions = [
            1 => [
                'left' => ['numerator' => 1, 'denominator' => 2],
                'right' => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '=',
                'valid_symbols' => ['=']
            ],
            2 => [
                'left' => ['numerator' => 3, 'denominator' => 4],
                'right' => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '>',
                'valid_symbols' => ['>']
            ],
            3 => [
                'left' => ['numerator' => 2, 'denominator' => 6],
                'right' => ['numerator' => 3, 'denominator' => 6],
                'correct_symbol' => '<',
                'valid_symbols' => ['<']
            ],
            4 => [
                'left' => ['numerator' => 4, 'denominator' => 8],
                'right' => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '=',
                'valid_symbols' => ['=']
            ],
            5 => [
                'left' => ['numerator' => 5, 'denominator' => 6],
                'right' => ['numerator' => 4, 'denominator' => 6],
                'correct_symbol' => '>',
                'valid_symbols' => ['>']
            ]
        ];

        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkBalanceAnswer(Request $request)
    {
        try {
            $level = session('balance_level', 1);
            $question = $this->generateBalanceQuestion($level);
            
            $selectedSymbol = trim($request->input('selected_symbol'));
            
            // Check if the selected symbol matches the correct symbol
            $correct = $selectedSymbol === $question['correct_symbol'];
            
            if ($correct && $level < 5) {
                session(['balance_level' => $level + 1]);
            }
            
            return response()->json([
                'correct' => $correct,
                'next_level' => $correct && $level < 5
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'details' => $e->getMessage()
            ], 400);
        }
    }

    public function resetBalanceGame()
    {
        session()->forget('balance_level');
        return redirect()->route('games.lop4.phanso.balance');
    }
    // Bracket Game Methods
    public function bracketGame()
    {
        $level = session('bracket_level', 1);
        $question = $this->generateBracketQuestion($level);
        return view('games.lop4.phanso.bracket', compact('question'));
    }

    private function generateBracketQuestion($level)
    {
        $questions = [
            1 => [
                'expression' => '(1/2 + 1/4)', 
                'answer' => ['numerator' => 3, 'denominator' => 4],
                'options' => [
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 5, 'denominator' => 4]
                ]
            ],
            2 => [
                'expression' => '(2/3 + 1/6)', 
                'answer' => ['numerator' => 5, 'denominator' => 6],
                'options' => [
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 5, 'denominator' => 6],
                    ['numerator' => 1, 'denominator' => 1]
                ]
            ],
            3 => [
                'expression' => '(3/4 - 1/4)', 
                'answer' => ['numerator' => 1, 'denominator' => 2],
                'options' => [
                    ['numerator' => 1, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 1]
                ]
            ],
            4 => [
                'expression' => '(1/2 + 1/3)', 
                'answer' => ['numerator' => 5, 'denominator' => 6],
                'options' => [
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 5, 'denominator' => 6],
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 7, 'denominator' => 6]
                ]
            ],
            5 => [
                'expression' => '(2/3 - 1/6)', 
                'answer' => ['numerator' => 1, 'denominator' => 2],
                'options' => [
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 5, 'denominator' => 6]
                ]
            ]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkBracketAnswer(Request $request)
    {
        $level = session('bracket_level', 1);
        $question = $this->generateBracketQuestion($level);
        
        $answer = $request->input('answer');
        $correct = $answer['numerator'] == $question['answer']['numerator'] && 
                  $answer['denominator'] == $question['answer']['denominator'];
        
        if ($correct && $level < 5) {
            session(['bracket_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetBracketGame()
    {
        session()->forget('bracket_level');
        return redirect()->route('games.lop4.phanso.bracket');
    }
    // Base Games
    public function cakeGame()
    {
        // Get current level from session or default to 1
        $level = session('cake_level', 1);

        // Generate question based on level
        $question = $this->generateCakeQuestion($level);

        return view('games.lop4.phanso.cake', compact('question'));
    }

    private function generateCakeQuestion($level)
    {
        // Define questions for each level
        $questions = [
            1 => ['numerator' => 1, 'denominator' => 2],  // Level 1: 1/2
            2 => ['numerator' => 2, 'denominator' => 4],  // Level 2: 2/4
            3 => ['numerator' => 3, 'denominator' => 6],  // Level 3: 3/6
            4 => ['numerator' => 4, 'denominator' => 8],  // Level 4: 4/8
            5 => ['numerator' => 5, 'denominator' => 10], // Level 5: 5/10
        ];

        // Get question for current level or default to level 1
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;

        return $question;
    }

    public function checkCakeAnswer(Request $request)
    {
        $level = session('cake_level', 1);
        $question = $this->generateCakeQuestion($level);
        
        $selectedPieces = json_decode($request->input('selected_pieces'), true);
        $numerator = $request->input('numerator');
        
        // Check if correct number of pieces are selected
        $correct = count($selectedPieces) === $question['numerator'];
        
        if ($correct) {
            // If current level completed, increment level
            if ($level < 5) {
                session(['cake_level' => $level + 1]);
            }
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetCakeGame()
    {
        session()->forget('cake_level');
        return redirect()->route('games.lop4.phanso.cake');
    }

    // Cards Game Methods
    public function cardsGame()
    {
        $level = session('cards_level', 1);
        $question = $this->generateCardsQuestion($level);
        return view('games.lop4.phanso.cards', compact('question'));
    }

    private function generateCardsQuestion($level)
    {
        $questions = [
            1 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 1, 'denominator' => 2, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 2, 'denominator' => 4, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 2, 'denominator' => 3, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 4, 'denominator' => 6, 'pairId' => 2]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.5],
                    ['id' => 2, 'value' => 0.667]
                ]
            ],
            2 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 3, 'denominator' => 4, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 6, 'denominator' => 8, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 2, 'denominator' => 5, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 4, 'denominator' => 10, 'pairId' => 2]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.75],
                    ['id' => 2, 'value' => 0.4]
                ]
            ],
            3 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 2, 'denominator' => 6, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 1, 'denominator' => 3, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 3, 'denominator' => 9, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 1, 'denominator' => 3, 'pairId' => 2]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.333],
                    ['id' => 2, 'value' => 0.333]
                ]
            ],
            4 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 4, 'denominator' => 8, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 1, 'denominator' => 2, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 6, 'denominator' => 9, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 2, 'denominator' => 3, 'pairId' => 2]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.5],
                    ['id' => 2, 'value' => 0.667]
                ]
            ],
            5 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 5, 'denominator' => 10, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 1, 'denominator' => 2, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 8, 'denominator' => 12, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 2, 'denominator' => 3, 'pairId' => 2]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.5],
                    ['id' => 2, 'value' => 0.667]
                ]
            ]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkCardsAnswer(Request $request)
    {
        try {
            $level = session('cards_level', 1);
            $question = $this->generateCardsQuestion($level);
            
            $selectedPairs = $request->input('selected_pairs');
            if (!is_array($selectedPairs)) {
                throw new \Exception('Invalid pairs format');
            }
            
            // Check if we have the correct number of pairs
            if (count($selectedPairs) !== count($question['pairs'])) {
                return response()->json([
                    'correct' => false,
                    'next_level' => false,
                    'message' => 'Chưa tìm đủ số cặp phân số bằng nhau!'
                ]);
            }
            
            $correct = true;
            $foundPairIds = [];
            
            // Check if all selected pairs are correct
            foreach ($selectedPairs as $pair) {
                if (!isset($pair[0], $pair[1]) || !isset($question['cards'][$pair[0]], $question['cards'][$pair[1]])) {
                    $correct = false;
                    break;
                }
                
                $card1 = collect($question['cards'])->firstWhere('id', $pair[0]);
                $card2 = collect($question['cards'])->firstWhere('id', $pair[1]);
                
                
                // Check if this pair matches
                if ($card1['pairId'] !== $card2['pairId']) {
                    $correct = false;
                    break;
                }
                
                // Track found pair IDs
                $foundPairIds[] = $card1['pairId'];
            }
            
            // Verify we found all unique pairs
            $foundPairIds = array_unique($foundPairIds);
            if (count($foundPairIds) !== count($question['pairs'])) {
                $correct = false;
            }
            
            if ($correct) {
                // Only increment level if answer is correct and there's a next level
                if ($level < 5) {
                    session(['cards_level' => $level + 1]);
                }
                
                return response()->json([
                    'correct' => true,
                    'next_level' => $level < 5,
                    'message' => $level < 5 
                        ? 'Tuyệt vời! Chuẩn bị chuyển sang cấp độ tiếp theo!' 
                        : 'Chúc mừng! Bạn đã hoàn thành tất cả các cấp độ!'
                ]);
            }
            
            return response()->json([
                'correct' => false,
                'next_level' => false,
                'message' => 'Các cặp phân số chưa khớp. Hãy thử lại nhé!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'details' => $e->getMessage()
            ], 400);
        }
    }

    public function resetCardsGame()
    {
        session()->forget('cards_level');
        return redirect()->route('games.lop4.phanso.cards');
    }

     // Compare Game Methods
     public function compareGame()
     {
         $level = session('compare_level', 1);
         $question = $this->generateCompareQuestion($level);
         return view('games.lop4.phanso.compare', compact('question'));
     }
 
     private function generateCompareQuestion($level)
     {
         $questions = [
             1 => [
                 'left' => ['numerator' => 1, 'denominator' => 2],
                 'right' => ['numerator' => 2, 'denominator' => 4],
                 'correct_symbol' => '='
             ],
             2 => [
                 'left' => ['numerator' => 3, 'denominator' => 4],
                 'right' => ['numerator' => 2, 'denominator' => 3],
                 'correct_symbol' => '>'
             ],
             3 => [
                 'left' => ['numerator' => 2, 'denominator' => 5],
                 'right' => ['numerator' => 3, 'denominator' => 4],
                 'correct_symbol' => '<'
             ],
             4 => [
                 'left' => ['numerator' => 5, 'denominator' => 6],
                 'right' => ['numerator' => 7, 'denominator' => 8],
                 'correct_symbol' => '<'
             ],
             5 => [
                 'left' => ['numerator' => 4, 'denominator' => 5],
                 'right' => ['numerator' => 3, 'denominator' => 4],
                 'correct_symbol' => '>'
             ]
         ];
         $question = $questions[$level] ?? $questions[1];
         $question['level'] = $level;
         return $question;
     }
 
     public function checkCompareAnswer(Request $request)
     {
         $level = session('compare_level', 1);
         $question = $this->generateCompareQuestion($level);
         
         $selectedSymbol = $request->input('selected_symbol');
         $correct = $selectedSymbol === $question['correct_symbol'];
         
         if ($correct && $level < 5) {
             session(['compare_level' => $level + 1]);
         }
         
         return response()->json([
             'correct' => $correct,
             'next_level' => $correct && $level < 5
         ]);
     }
 
     public function resetCompareGame()
     {
         session()->forget('compare_level');
         return redirect()->route('games.lop4.phanso.compare');
     }
    // Division Game Methods
    public function divisionGame()
    {
        $level = session('division_level', 1);
        $question = $this->generateDivisionQuestion($level);
        return view('games.lop4.phanso.division', compact('question'));
    }

    private function generateDivisionQuestion($level)
    {
        $questions = [
            1 => [
                'dividend' => ['numerator' => 2, 'denominator' => 4],
                'divisor' => ['numerator' => 1, 'denominator' => 2],
                'answer' => ['numerator' => 1, 'denominator' => 1],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ],
            2 => [
                'dividend' => ['numerator' => 3, 'denominator' => 6],
                'divisor' => ['numerator' => 1, 'denominator' => 2],
                'answer' => ['numerator' => 1, 'denominator' => 1],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 3]
                ]
            ],
            3 => [
                'dividend' => ['numerator' => 4, 'denominator' => 8],
                'divisor' => ['numerator' => 1, 'denominator' => 2],
                'answer' => ['numerator' => 1, 'denominator' => 1],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ],
            4 => [
                'dividend' => ['numerator' => 6, 'denominator' => 9],
                'divisor' => ['numerator' => 2, 'denominator' => 3],
                'answer' => ['numerator' => 1, 'denominator' => 1],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 3]
                ]
            ],
            5 => [
                'dividend' => ['numerator' => 8, 'denominator' => 12],
                'divisor' => ['numerator' => 2, 'denominator' => 3],
                'answer' => ['numerator' => 1, 'denominator' => 1],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ]
        ];

        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkDivisionAnswer(Request $request)
    {
        try {
            $level = session('division_level', 1);
            $question = $this->generateDivisionQuestion($level);
            
            $answer = [
                'numerator' => (int) $request->input('numerator'),
                'denominator' => (int) $request->input('denominator')
            ];
            
            // Check if the answer matches any of the valid answers
            $correct = false;
            foreach ($question['answers'] as $validAnswer) {
                if ($answer['numerator'] * $validAnswer['denominator'] === 
                    $answer['denominator'] * $validAnswer['numerator']) {
                    $correct = true;
                    break;
                }
            }
            
            if ($correct && $level < 5) {
                session(['division_level' => $level + 1]);
            }
            
            return response()->json([
                'correct' => $correct,
                'next_level' => $correct && $level < 5
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'details' => $e->getMessage()
            ], 400);
        }
    }

    public function getDivisionQuestion()
    {
        $level = session('division_level', 1);
        $question = $this->generateDivisionQuestion($level);
        $question['level'] = $level;
        return view('games.lop4.phanso.division', compact('question'));
    }

    public function resetDivisionGame()
    {
        session()->forget('division_level');
        return redirect()->route('games.lop4.phanso.division');
    }
     // Equal Groups Game Methods
     public function equalGroupsGame()
     {
         $level = session('equal_groups_level', 1);
         $question = $this->generateEqualGroupsQuestion($level);
         return view('games.lop4.phanso.equal_groups', compact('question'));
     }
 
    
    public function fairShare() {
        $level = session('fair_share_level', 1);
        $question = $this->generateFairShareQuestion($level);
        return view('games.lop4.kham_pha_phan_so.fair_share', compact('level'));
    }
    // Garden Game Methods
    public function gardenGame()
    {
        $level = session('garden_level', 1);
        $question = $this->generateGardenQuestion($level);
        return view('games.lop4.phanso.garden', compact('question'));
    }

    private function generateGardenQuestion($level)
    {
        $questions = [
            1 => [
                'numerator' => 2,
                'denominator' => 4,
                'simplifiedNumerator' => 1,
                'simplifiedDenominator' => 2,
                'gridRows' => 2,
                'gridCols' => 2
            ],
            2 => [
                'numerator' => 3,
                'denominator' => 6,
                'simplifiedNumerator' => 1,
                'simplifiedDenominator' => 2,
                'gridRows' => 2,
                'gridCols' => 3
            ],
            3 => [
                'numerator' => 4,
                'denominator' => 8,
                'simplifiedNumerator' => 1,
                'simplifiedDenominator' => 2,
                'gridRows' => 2,
                'gridCols' => 4
            ],
            4 => [
                'numerator' => 6,
                'denominator' => 9,
                'simplifiedNumerator' => 2,
                'simplifiedDenominator' => 3,
                'gridRows' => 3,
                'gridCols' => 3
            ],
            5 => [
                'numerator' => 8,
                'denominator' => 12,
                'simplifiedNumerator' => 2,
                'simplifiedDenominator' => 3,
                'gridRows' => 3,
                'gridCols' => 4
            ]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkGardenAnswer(Request $request)
    {
        $level = session('garden_level', 1);
        $question = $this->generateGardenQuestion($level);
        
        $answer = [
            'numerator' => (int) $request->input('numerator'),
            'denominator' => (int) $request->input('denominator')
        ];
        
        $correct = $answer['numerator'] === $question['simplifiedNumerator'] &&
                  $answer['denominator'] === $question['simplifiedDenominator'];
        
        if ($correct && $level < 5) {
            session(['garden_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetGardenGame()
    {
        session()->forget('garden_level');
        return redirect()->route('games.lop4.phanso.garden');
    }

    public function khamPhaPhanSo() {
        return view('games.lop4.kham_pha_phan_so.kham_pha_phan_so');
    }
   // Lost City Game Methods
   public function lostCityGame()
   {
       $level = session('lost_city_level', 1);
       $question = session('lost_city_question');
       
       if (!$question) {
           $question = $this->generateLostCityQuestion($level);
           session(['lost_city_question' => $question]);
       }
       
       return view('games.lop4.phanso.lost_city', compact('question'));
   }

   private function generateLostCityQuestion($level)
   {
       // Định nghĩa phạm vi số cho từng cấp độ
       $ranges = [
           1 => ['min' => 2, 'max' => 10],    // Cấp độ 1: Số nhỏ, dễ chia
           2 => ['min' => 10, 'max' => 20],   // Cấp độ 2: Số trung bình
           3 => ['min' => 20, 'max' => 50],   // Cấp độ 3: Số lớn hơn
           4 => ['min' => 30, 'max' => 100],  // Cấp độ 4: Số lớn
           5 => ['min' => 50, 'max' => 200]   // Cấp độ 5: Số rất lớn
       ];

       $range = $ranges[$level];
       $streets = [];

       // Tạo 3 câu hỏi cho mỗi cấp độ
       for ($i = 0; $i < 3; $i++) {
           // Tạo số bị chia (total) và số chia (divisor) sao cho chia hết
           do {
               $total = rand($range['min'], $range['max']);
               // Lấy các ước số của total trong phạm vi phù hợp với cấp độ
               $divisors = [];
               for ($d = 2; $d <= min(12, $total); $d++) {
                   if ($total % $d == 0) {
                       $divisors[] = $d;
                   }
               }
               // Chọn ngẫu nhiên một ước số
               if (!empty($divisors)) {
                   $divisor = $divisors[array_rand($divisors)];
                   $result = $total / $divisor;
                   // Kiểm tra xem kết quả có phù hợp không
                   if ($result >= 2 && $result <= ($range['max'] / 2)) {
                       break;
                   }
               }
           } while (true);

           // Tạo câu hỏi với các dạng khác nhau tùy theo cấp độ
           $questionTypes = [
               // Cấp độ 1-2: Câu hỏi đơn giản
               [
                   'description' => "Một phần ___ của $total là $result",
                   'hint' => "$result = $total ÷ ___"
               ],
               // Cấp độ 3-4: Thêm từ ngữ toán học
               [
                   'description' => "Khi chia $total cho ___ thì được $result",
                   'hint' => "$total ÷ ___ = $result"
               ],
               // Cấp độ 5: Câu hỏi phức tạp hơn
               [
                   'description' => "Số ___ là số chia khi chia $total được $result",
                   'hint' => "$total ÷ ___ = $result"
               ]
           ];

           // Chọn loại câu hỏi phù hợp với cấp độ
           $questionType = $level <= 2 ? $questionTypes[0] : 
                         ($level <= 4 ? $questionTypes[1] : $questionTypes[2]);

           $streetNames = [
               ['name' => 'Đường Phân Số', 'icon' => '🔢'],
               ['name' => 'Phố Toán Học', 'icon' => '📐'],
               ['name' => 'Ngõ Số Học', 'icon' => '📏'],
               ['name' => 'Đường Tính Toán', 'icon' => '➗'],
               ['name' => 'Phố Chia Số', 'icon' => '✖️'],
               ['name' => 'Ngõ Phép Tính', 'icon' => '➕'],
               ['name' => 'Đường Số Học', 'icon' => '📊'],
               ['name' => 'Phố Toán Tư Duy', 'icon' => '🎯'],
               ['name' => 'Ngõ Suy Luận', 'icon' => '🎲']
           ];

           $streetName = $streetNames[array_rand($streetNames)];

           $streets[] = [
               'id' => $i + 1,
               'name' => $streetName['name'] . ' ' . $streetName['icon'],
               'description' => $questionType['description'],
               'answer' => (string)$divisor,
               'hint' => $questionType['hint']
           ];
       }

       return [
           'level' => $level,
           'streets' => $streets,
           'hint' => match($level) {
               1 => 'Hãy tìm số chia để có kết quả đúng',
               2 => 'Thử chia số lớn cho số nhỏ hơn',
               3 => 'Tìm số chia phù hợp để được kết quả',
               4 => 'Suy luận từ kết quả để tìm số chia',
               5 => 'Vận dụng kỹ năng tính toán nâng cao',
               default => 'Điền số thích hợp vào chỗ trống'
           }
       ];
   }

   public function checkLostCityAnswer(Request $request)
   {
       $level = session('lost_city_level', 1);
       $question = session('lost_city_question');
       
       if (!$question) {
           return response()->json([
               'correct' => false,
               'error' => 'Phiên làm việc đã hết hạn'
           ]);
       }
       
       $answers = $request->input('answers', []);
       $correct = true;
       
       foreach ($question['streets'] as $index => $street) {
           if (!isset($answers[$index]) || (string)$answers[$index] !== $street['answer']) {
               $correct = false;
               break;
           }
       }
       
       if ($correct) {
           if ($level < 5) {
               session(['lost_city_level' => $level + 1]);
               session()->forget('lost_city_question'); // Clear current questions for next level
           }
       }
       
       return response()->json([
           'correct' => $correct,
           'next_level' => $correct && $level < 5
       ]);
   }

   public function resetLostCityGame()
   {
       session()->forget(['lost_city_level', 'lost_city_question']);
       return redirect()->route('games.lop4.phanso.lost_city');
   }

   // Pattern Game Methods
   public function patternGame()
   {
       $level = session('pattern_level', 1);
       $question = $this->generatePatternQuestion($level);
       return view('games.lop4.phanso.pattern', compact('question'));
   }

   private function generatePatternQuestion($level)
   {
       $questions = [
           1 => [
               'sequence' => [
                   ['numerator' => 1, 'denominator' => 4],
                   ['numerator' => 2, 'denominator' => 4],
                   ['numerator' => 3, 'denominator' => 4],
                   ['numerator' => 4, 'denominator' => 4]
               ],
               'answer' => ['numerator' => 5, 'denominator' => 4]
           ],
           2 => [
               'sequence' => [
                   ['numerator' => 1, 'denominator' => 3],
                   ['numerator' => 2, 'denominator' => 3],
                   ['numerator' => 3, 'denominator' => 3],
                   ['numerator' => 4, 'denominator' => 3]
               ],
               'answer' => ['numerator' => 5, 'denominator' => 3]
           ],
           3 => [
               'sequence' => [
                   ['numerator' => 1, 'denominator' => 5],
                   ['numerator' => 2, 'denominator' => 5],
                   ['numerator' => 3, 'denominator' => 5],
                   ['numerator' => 4, 'denominator' => 5]
               ],
               'answer' => ['numerator' => 5, 'denominator' => 5]
           ],
           4 => [
               'sequence' => [
                   ['numerator' => 2, 'denominator' => 6],
                   ['numerator' => 3, 'denominator' => 6],
                   ['numerator' => 4, 'denominator' => 6],
                   ['numerator' => 5, 'denominator' => 6]
               ],
               'answer' => ['numerator' => 6, 'denominator' => 6]
           ],
           5 => [
               'sequence' => [
                   ['numerator' => 3, 'denominator' => 8],
                   ['numerator' => 4, 'denominator' => 8],
                   ['numerator' => 5, 'denominator' => 8],
                   ['numerator' => 6, 'denominator' => 8]
               ],
               'answer' => ['numerator' => 7, 'denominator' => 8]
           ]
       ];
       $question = $questions[$level] ?? $questions[1];
       $question['level'] = $level;
       return $question;
   }

   public function checkPatternAnswer(Request $request)
   {
       $level = session('pattern_level', 1);
       $question = $this->generatePatternQuestion($level);
       
       $answer = $request->input('answer');
       $correct = $answer === $question['answer'];
       
       if ($correct && $level < 5) {
           session(['pattern_level' => $level + 1]);
       }
       
       return response()->json([
           'correct' => $correct,
           'next_level' => $correct && $level < 5
       ]);
   }

   public function resetPatternGame()
   {
       session()->forget('pattern_level');
       return redirect()->route('games.lop4.phanso.pattern');
   }

    public function phanso() {
        $level = session('phanso_level', 1);
        $question = $this->generatePhansoQuestion($level);
        return view('games.lop4.kham_pha_phan_so.phanso', compact('level'));
    }
     // Remaining Cake Game Methods
     public function remainingCakeGame()
     {
         $level = session('remaining_cake_level', 1);
         $question = $this->generateRemainingCakeQuestion($level);
         return view('games.lop4.phanso.remaining_cake', compact('question'));
     }
 
     private function generateRemainingCakeQuestion($level)
     {
         $questions = [
             1 => [
                 'level' => 1,
                 'eaten' => ['numerator' => 3, 'denominator' => 8],
                 'remaining' => ['numerator' => 5, 'denominator' => 8]  // 8/8 - 3/8 = 5/8
             ],
             2 => [
                 'level' => 2,
                 'eaten' => ['numerator' => 2, 'denominator' => 6],
                 'remaining' => ['numerator' => 4, 'denominator' => 6]  // 6/6 - 2/6 = 4/6
             ],
             3 => [
                 'level' => 3,
                 'eaten' => ['numerator' => 5, 'denominator' => 12],
                 'remaining' => ['numerator' => 7, 'denominator' => 12]  // 12/12 - 5/12 = 7/12
             ],
             4 => [
                 'level' => 4,
                 'eaten' => ['numerator' => 3, 'denominator' => 10],
                 'remaining' => ['numerator' => 7, 'denominator' => 10]  // 10/10 - 3/10 = 7/10
             ],
             5 => [
                 'level' => 5,
                 'eaten' => ['numerator' => 4, 'denominator' => 9],
                 'remaining' => ['numerator' => 5, 'denominator' => 9]  // 9/9 - 4/9 = 5/9
             ]
         ];
 
         return $questions[$level] ?? $questions[1];
     }
 
     public function checkRemainingCakeAnswer(Request $request)
     {
         try {
             $level = session('remaining_cake_level', 1);
             $question = $this->generateRemainingCakeQuestion($level);
             
             $numerator = (int) $request->input('numerator');
             $denominator = (int) $request->input('denominator');
             
             // Kiểm tra đáp án
             $remainingNumerator = $question['remaining']['numerator'];
             $remainingDenominator = $question['remaining']['denominator'];
             
             // So sánh phân số (a/b = c/d nếu a*d = b*c)
             $correct = ($numerator * $remainingDenominator) === ($denominator * $remainingNumerator);
             
             if ($correct && $level < 5) {
                 session(['remaining_cake_level' => $level + 1]);
             }
             
             return response()->json([
                 'correct' => $correct,
                 'next_level' => $correct && $level < 5
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                 'details' => $e->getMessage()
             ], 400);
         }
     }
 
     public function resetRemainingCakeGame()
     {
         session()->forget('remaining_cake_level');
         return redirect()->route('games.lop4.phanso.remaining_cake');
     }
     // Sentence Game Methods
     public function sentenceGame()
     {
         $level = session('sentence_level', 1);
         $question = $this->generateSentenceQuestion($level);
         return view('games.lop4.phanso.sentence', compact('question'));
     }
 
     private function generateSentenceQuestion($level)
     {
         $questions = [
             1 => [
                 'level' => 1,
                 'text' => 'Một cái bánh được chia làm 4 phần bằng nhau. An ăn 1 phần, Bình ăn 2 phần. Hỏi An và Bình đã ăn bao nhiêu phần bánh?',
                 'answer' => ['numerator' => 3, 'denominator' => 4],
                 'hint' => 'Cộng số phần bánh mà An và Bình đã ăn: 1/4 + 2/4 = 3/4'
             ],
             2 => [
                 'level' => 2,
                 'text' => 'Một thanh chocolate được chia làm 6 phần bằng nhau. Mai ăn 2 phần, Lan ăn 3 phần. Hỏi Mai và Lan đã ăn bao nhiêu phần chocolate?',
                 'answer' => ['numerator' => 5, 'denominator' => 6],
                 'hint' => 'Cộng số phần chocolate mà Mai và Lan đã ăn: 2/6 + 3/6 = 5/6'
             ],
             3 => [
                 'level' => 3,
                 'text' => 'Một miếng pizza được chia làm 8 phần bằng nhau. Nam ăn 3 phần, Hoa ăn 2 phần. Hỏi Nam và Hoa đã ăn bao nhiêu phần pizza?',
                 'answer' => ['numerator' => 5, 'denominator' => 8],
                 'hint' => 'Cộng số phần pizza mà Nam và Hoa đã ăn: 3/8 + 2/8 = 5/8'
             ],
             4 => [
                 'level' => 4,
                 'text' => 'Một quả táo được chia làm 10 phần bằng nhau. Tùng ăn 4 phần, Thảo ăn 3 phần. Hỏi Tùng và Thảo đã ăn bao nhiêu phần táo?',
                 'answer' => ['numerator' => 7, 'denominator' => 10],
                 'hint' => 'Cộng số phần táo mà Tùng và Thảo đã ăn: 4/10 + 3/10 = 7/10'
             ],
             5 => [
                 'level' => 5,
                 'text' => 'Một cái bánh kem được chia làm 12 phần bằng nhau. Hùng ăn 5 phần, Minh ăn 4 phần. Hỏi Hùng và Minh đã ăn bao nhiêu phần bánh?',
                 'answer' => ['numerator' => 9, 'denominator' => 12],
                 'hint' => 'Cộng số phần bánh mà Hùng và Minh đã ăn: 5/12 + 4/12 = 9/12'
             ]
         ];
 
         return $questions[$level] ?? $questions[1];
     }
 
     public function checkSentenceAnswer(Request $request)
     {
         try {
             $level = session('sentence_level', 1);
             $question = $this->generateSentenceQuestion($level);
             
             $numerator = (int) $request->input('numerator');
             $denominator = (int) $request->input('denominator');
             
             // Kiểm tra đáp án
             $answerNumerator = $question['answer']['numerator'];
             $answerDenominator = $question['answer']['denominator'];
             
             // So sánh phân số (a/b = c/d nếu a*d = b*c)
             $correct = ($numerator * $answerDenominator) === ($denominator * $answerNumerator);
             
             if ($correct && $level < 5) {
                 session(['sentence_level' => $level + 1]);
             }
             
             return response()->json([
                 'correct' => $correct,
                 'next_level' => $correct && $level < 5
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                 'details' => $e->getMessage()
             ], 400);
         }
     }
 
     public function resetSentenceGame()
     {
         session()->forget('sentence_level');
         return redirect()->route('games.lop4.phanso.sentence');
     }
     // Sky Game Methods
     public function skyGame()
     {
         $level = session('sky_level', 1);
         $question = $this->generateSkyQuestion($level);
         return view('games.lop4.phanso.sky', compact('question'));
     }
 
     private function generateSkyQuestion($level)
     {
         $questions = [
             1 => [
                 'level' => 1,
                 'fractions' => [
                     ['numerator' => 1, 'denominator' => 2],
                     ['numerator' => 2, 'denominator' => 4],
                     ['numerator' => 3, 'denominator' => 4],
                 ],
                 'correct_index' => 2  // 3/4 là lớn nhất
             ],
             2 => [
                 'level' => 2,
                 'fractions' => [
                     ['numerator' => 2, 'denominator' => 3],
                     ['numerator' => 3, 'denominator' => 4],
                     ['numerator' => 4, 'denominator' => 6],
                 ],
                 'correct_index' => 1  // 3/4 là lớn nhất
             ],
             3 => [
                 'level' => 3,
                 'fractions' => [
                     ['numerator' => 5, 'denominator' => 6],
                     ['numerator' => 3, 'denominator' => 4],
                     ['numerator' => 7, 'denominator' => 8],
                 ],
                 'correct_index' => 0  // 5/6 là lớn nhất
             ],
             4 => [
                 'level' => 4,
                 'fractions' => [
                     ['numerator' => 4, 'denominator' => 5],
                     ['numerator' => 5, 'denominator' => 6],
                     ['numerator' => 6, 'denominator' => 7],
                 ],
                 'correct_index' => 2  // 6/7 là lớn nhất
             ],
             5 => [
                 'level' => 5,
                 'fractions' => [
                     ['numerator' => 7, 'denominator' => 8],
                     ['numerator' => 8, 'denominator' => 9],
                     ['numerator' => 9, 'denominator' => 10],
                 ],
                 'correct_index' => 1  // 8/9 là lớn nhất
             ]
         ];
 
         return $questions[$level] ?? $questions[1];
     }
 
     public function checkSkyAnswer(Request $request)
     {
         try {
             $level = session('sky_level', 1);
             $question = $this->generateSkyQuestion($level);
             
             $selectedIndex = (int) $request->input('selected_index');
             $correct = $selectedIndex === $question['correct_index'];
             
             if ($correct && $level < 5) {
                 session(['sky_level' => $level + 1]);
             }
             
             return response()->json([
                 'correct' => $correct,
                 'next_level' => $correct && $level < 5
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                 'details' => $e->getMessage()
             ], 400);
         }
     }
 
     public function resetSkyGame()
     {
         session()->forget('sky_level');
         return redirect()->route('games.lop4.phanso.sky');
     }
    // Tower Game Methods
    public function towerGame()
    {
        $level = session('tower_level', 1);
        $question = $this->generateTowerQuestion($level);
        return view('games.lop4.phanso.tower', compact('question'));
    }

    private function generateTowerQuestion($level)
    {
        $questions = [
            1 => [
                'fractions' => [
                    ['numerator' => 1, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 4]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            2 => [
                'fractions' => [
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 1, 'denominator' => 1]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            3 => [
                'fractions' => [
                    ['numerator' => 1, 'denominator' => 6],
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 1, 'denominator' => 2]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            4 => [
                'fractions' => [
                    ['numerator' => 2, 'denominator' => 8],
                    ['numerator' => 3, 'denominator' => 8],
                    ['numerator' => 4, 'denominator' => 8]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            5 => [
                'fractions' => [
                    ['numerator' => 1, 'denominator' => 5],
                    ['numerator' => 2, 'denominator' => 5],
                    ['numerator' => 3, 'denominator' => 5]
                ],
                'correctOrder' => [0, 1, 2]
            ]
        ];

        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkTowerAnswer(Request $request)
    {
        try {
            $level = session('tower_level', 1);
            $question = $this->generateTowerQuestion($level);
            
            $selectedOrder = json_decode($request->input('order'), true);
            if (!is_array($selectedOrder)) {
                throw new \Exception('Invalid order format');
            }
            
            $correct = $selectedOrder === $question['correctOrder'];
            
            if ($correct && $level < 5) {
                session(['tower_level' => $level + 1]);
            }
            
            return response()->json([
                'correct' => $correct,
                'next_level' => $correct && $level < 5
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'details' => $e->getMessage()
            ], 400);
        }
    }

    public function resetTowerGame()
    {
        session()->forget('tower_level');
        return redirect()->route('games.lop4.phanso.tower');
    }
    // Word Hunt Game Methods
    public function wordHuntGame()
    {
        $level = session('word_hunt_level', 1);
        $question = $this->generateWordHuntQuestion($level);
        return view('games.lop4.phanso.word_hunt', compact('question'));
    }

    private function generateWordHuntQuestion($level)
    {
        $questions = [
            1 => [
                'target' => '1/2',
                'options' => ['2/4', '3/6', '4/8', '5/10'],
                'hint' => 'Tìm các phân số bằng 1/2'
            ],
            2 => [
                'target' => '2/3',
                'options' => ['4/6', '6/9', '8/12', '10/15'],
                'hint' => 'Tìm các phân số bằng 2/3'
            ],
            3 => [
                'target' => '3/4',
                'options' => ['6/8', '9/12', '12/16', '15/20'],
                'hint' => 'Tìm các phân số bằng 3/4'
            ],
            4 => [
                'target' => '5/6',
                'options' => ['10/12', '15/18', '20/24', '25/30'],
                'hint' => 'Tìm các phân số bằng 5/6'
            ],
            5 => [
                'target' => '7/8',
                'options' => ['14/16', '21/24', '28/32', '35/40'],
                'hint' => 'Tìm các phân số bằng 7/8'
            ]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkWordHuntAnswer(Request $request)
    {
        $level = session('word_hunt_level', 1);
        $question = $this->generateWordHuntQuestion($level);
        
        $selectedFractions = $request->input('selected_fractions', []);
        $correct = $this->checkEquivalentFractions($selectedFractions, $question['target']);
        
        if ($correct && $level < 5) {
            session(['word_hunt_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetWordHuntGame()
    {
        session()->forget('word_hunt_level');
        return redirect()->route('games.lop4.phanso.word_hunt');
    }
    // Word Problem Game Methods
    public function wordProblemGame()
    {
        $level = session('word_problem_level', 1);
        $question = $this->generateWordProblem($level);
        return view('games.lop4.phanso.word_problem', compact('question'));
    }

    private function generateWordProblem($level)
    {
        $stories = [
            1 => [
                'story' => 'Một cái bánh được chia thành 8 phần bằng nhau. An ăn 3 phần, Bình ăn 2 phần. Hỏi còn lại bao nhiêu phần bánh?',
                'numerator' => 3,
                'denominator' => 8,
                'level' => 1,
                'answer' => ['numerator' => 3, 'denominator' => 8]  // 8 - (3 + 2) = 3 phần
            ],
            2 => [
                'story' => 'Một miếng pizza được chia thành 6 phần bằng nhau. Mai ăn 2 phần, Lan ăn 1 phần. Hỏi còn lại bao nhiêu phần pizza?',
                'numerator' => 3,
                'denominator' => 6,
                'level' => 2,
                'answer' => ['numerator' => 3, 'denominator' => 6]  // 6 - (2 + 1) = 3 phần
            ],
            3 => [
                'story' => 'Một thanh chocolate được chia thành 10 phần bằng nhau. Nam ăn 4 phần, Hoa ăn 3 phần. Hỏi còn lại bao nhiêu phần chocolate?',
                'numerator' => 3,
                'denominator' => 10,
                'level' => 3,
                'answer' => ['numerator' => 3, 'denominator' => 10]  // 10 - (4 + 3) = 3 phần
            ],
            4 => [
                'story' => 'Một quả táo được chia thành 4 phần bằng nhau. Hùng ăn 1 phần, Minh ăn 1 phần. Hỏi còn lại bao nhiêu phần táo?',
                'numerator' => 2,
                'denominator' => 4,
                'level' => 4,
                'answer' => ['numerator' => 2, 'denominator' => 4]  // 4 - (1 + 1) = 2 phần
            ],
            5 => [
                'story' => 'Một cái bánh kem được chia thành 12 phần bằng nhau. Tùng ăn 3 phần, Thảo ăn 4 phần. Hỏi còn lại bao nhiêu phần bánh?',
                'numerator' => 5,
                'denominator' => 12,
                'level' => 5,
                'answer' => ['numerator' => 5, 'denominator' => 12]  // 12 - (3 + 4) = 5 phần
            ]
        ];

        return $stories[$level] ?? $stories[1];
    }

    public function checkWordProblemAnswer(Request $request)
    {
        try {
            $level = session('word_problem_level', 1);
            $question = $this->generateWordProblem($level);
            
            $answer = [
                'numerator' => (int) $request->input('numerator'),
                'denominator' => (int) $request->input('denominator')
            ];
            
            // Kiểm tra đáp án
            $correct = $answer['numerator'] === $question['answer']['numerator'] &&
                      $answer['denominator'] === $question['answer']['denominator'];
            
            if ($correct && $level < 5) {
                session(['word_problem_level' => $level + 1]);
            }
            
            return response()->json([
                'correct' => $correct,
                'next_level' => $correct && $level < 5
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'details' => $e->getMessage()
            ], 400);
        }
    }

    public function resetWordProblemGame()
    {
        session()->forget('word_problem_level');
        return redirect()->route('games.lop4.phanso.word_problem');
    }
    public function resetApple() {
        session()->forget('apple_level');
        return redirect()->route('games.lop4.kham-pha-phan-so.apple');
    }

    public function resetBalance() {
        session(['balance_level' => 1]);
        return redirect()->route('games.lop4.kham_pha_phan_so.balance');
    }

    public function resetCompare() {
        session()->forget('compare_level');
        return redirect()->route('games.lop4.kham-pha-phan-so.compare');
    }

    
    public function resetCake() {
        session()->forget('cake_level');
        return redirect()->route('games.lop4.kham-pha-phan-so.cake');
    }

} 