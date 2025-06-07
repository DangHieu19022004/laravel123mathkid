<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Main Game Hub
    public function index()
    {
        return view('games.lop4.phanso.phanso');
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

    public function resetAppleGame()
    {
        session()->forget('apple_level');
        return redirect()->route('games.lop4.phanso.apple');
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
        $level = session('cards_level', 1);
        $question = $this->generateCardsQuestion($level);
        
        $selectedPairs = $request->input('selected_pairs', []);
        $correct = true;
        
        // Check if all selected pairs are correct
        foreach ($selectedPairs as $pair) {
            $card1 = $question['cards'][$pair[0]];
            $card2 = $question['cards'][$pair[1]];
            
            if ($card1['pairId'] !== $card2['pairId']) {
                $correct = false;
                break;
            }
        }
        
        // Check if all pairs were found
        $foundPairIds = [];
        foreach ($selectedPairs as $pair) {
            $card1 = $question['cards'][$pair[0]];
            $foundPairIds[] = $card1['pairId'];
        }
        $foundPairIds = array_unique($foundPairIds);
        
        if (count($foundPairIds) !== count($question['pairs'])) {
            $correct = false;
        }
        
        if ($correct && $level < 5) {
            session(['cards_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetCardsGame()
    {
        session()->forget('cards_level');
        return redirect()->route('games.lop4.phanso.cards');
    }

    // Helper method for checking fraction order
    private function checkFractionOrder($answer, $fractions, $order)
    {
        // Convert fractions to decimals for comparison
        $decimals = array_map(function($fraction) {
            list($num, $den) = explode('/', $fraction);
            return $num / $den;
        }, $fractions);
        
        if ($order === 'ascending') {
            $sorted = $decimals;
            sort($sorted);
            return $decimals === $sorted;
        } else {
            $sorted = $decimals;
            rsort($sorted);
            return $decimals === $sorted;
        }
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
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ],
            2 => [
                'dividend' => ['numerator' => 3, 'denominator' => 6],
                'divisor' => ['numerator' => 1, 'denominator' => 2],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 3]
                ]
            ],
            3 => [
                'dividend' => ['numerator' => 4, 'denominator' => 8],
                'divisor' => ['numerator' => 1, 'denominator' => 2],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ],
            4 => [
                'dividend' => ['numerator' => 6, 'denominator' => 9],
                'divisor' => ['numerator' => 2, 'denominator' => 3],
                'answers' => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 3]
                ]
            ],
            5 => [
                'dividend' => ['numerator' => 8, 'denominator' => 12],
                'divisor' => ['numerator' => 2, 'denominator' => 3],
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

    // Fair Share Game Methods
    public function fairShareGame()
    {
        $level = session('fair_share_level', 1);
        $question = $this->generateFairShareQuestion($level);
        return view('games.lop4.phanso.fair_share', compact('question'));
    }

    private function generateFairShareQuestion($level)
    {
        $questions = [
            1 => [
                'total' => ['numerator' => 4, 'denominator' => 1],
                'people' => 2,
                'answers' => [
                    ['numerator' => 2, 'denominator' => 1],
                    ['numerator' => 4, 'denominator' => 2]
                ],
                'item_type' => 'apple'
            ],
            2 => [
                'total' => ['numerator' => 6, 'denominator' => 1],
                'people' => 2,
                'answers' => [
                    ['numerator' => 3, 'denominator' => 1],
                    ['numerator' => 6, 'denominator' => 2]
                ],
                'item_type' => 'cake'
            ],
            3 => [
                'total' => ['numerator' => 6, 'denominator' => 1],
                'people' => 3,
                'answers' => [
                    ['numerator' => 2, 'denominator' => 1],
                    ['numerator' => 4, 'denominator' => 2]
                ],
                'item_type' => 'apple'
            ],
            4 => [
                'total' => ['numerator' => 8, 'denominator' => 1],
                'people' => 4,
                'answers' => [
                    ['numerator' => 2, 'denominator' => 1],
                    ['numerator' => 4, 'denominator' => 2]
                ],
                'item_type' => 'cake'
            ],
            5 => [
                'total' => ['numerator' => 10, 'denominator' => 1],
                'people' => 5,
                'answers' => [
                    ['numerator' => 2, 'denominator' => 1],
                    ['numerator' => 4, 'denominator' => 2]
                ],
                'item_type' => 'apple'
            ]
        ];

        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkFairShareAnswer(Request $request)
    {
        try {
            $level = session('fair_share_level', 1);
            $question = $this->generateFairShareQuestion($level);
            
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
                session(['fair_share_level' => $level + 1]);
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

    public function getFairShareQuestion()
    {
        $level = session('fair_share_level', 1);
        $question = $this->generateFairShareQuestion($level);
        $question['level'] = $level;
        return view('games.lop4.phanso.fair_share', compact('question'));
    }

    public function resetFairShareGame()
    {
        session()->forget('fair_share_level');
        return redirect()->route('games.lop4.phanso.fair_share');
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
            
            $selectedSymbol = trim($request->input('symbol'));
            
            // Check if the selected symbol is valid
            $correct = in_array($selectedSymbol, $question['valid_symbols']);
            
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

    // Helper method for comparing fractions
    private function checkComparison($fraction1, $fraction2, $operator)
    {
        list($num1, $den1) = explode('/', $fraction1);
        list($num2, $den2) = explode('/', $fraction2);
        
        $value1 = $num1 / $den1;
        $value2 = $num2 / $den2;
        
        switch ($operator) {
            case '>':
                return $value1 > $value2;
            case '<':
                return $value1 < $value2;
            case '=':
                return abs($value1 - $value2) < 0.000001;
            default:
                return false;
        }
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
                'answer' => ['numerator' => 3, 'denominator' => 8]
            ],
            2 => [
                'story' => 'Một miếng pizza được chia thành 6 phần bằng nhau. Mai ăn 2 phần, Lan ăn 1 phần. Hỏi còn lại bao nhiêu phần pizza?',
                'numerator' => 3,
                'denominator' => 6,
                'level' => 2,
                'answer' => ['numerator' => 3, 'denominator' => 6]
            ],
            3 => [
                'story' => 'Một thanh chocolate được chia thành 10 phần bằng nhau. Nam ăn 4 phần, Hoa ăn 3 phần. Hỏi còn lại bao nhiêu phần chocolate?',
                'numerator' => 3,
                'denominator' => 10,
                'level' => 3,
                'answer' => ['numerator' => 3, 'denominator' => 10]
            ],
            4 => [
                'story' => 'Một quả táo được chia thành 4 phần bằng nhau. Hùng ăn 1 phần, Minh ăn 1 phần. Hỏi còn lại bao nhiêu phần táo?',
                'numerator' => 2,
                'denominator' => 4,
                'level' => 4,
                'answer' => ['numerator' => 2, 'denominator' => 4]
            ],
            5 => [
                'story' => 'Một cái bánh kem được chia thành 12 phần bằng nhau. Tùng ăn 3 phần, Thảo ăn 4 phần. Hỏi còn lại bao nhiêu phần bánh?',
                'numerator' => 5,
                'denominator' => 12,
                'level' => 5,
                'answer' => ['numerator' => 5, 'denominator' => 12]
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

    // Sky Game Methods
    public function skyGame()
    {
        return view('games.lop4.phanso.sky');
    }

    public function checkSkyAnswer(Request $request)
    {
        // Validate and process sky game answer
        return response()->json(['success' => true]);
    }

    public function resetSkyGame()
    {
        // Reset sky game progress
        return redirect()->back();
    }

    // Remaining Cake Game Methods
    public function remainingCakeGame()
    {
        return view('games.lop4.phanso.remaining_cake');
    }

    public function checkRemainingCakeAnswer(Request $request)
    {
        // Validate and process remaining cake game answer
        return response()->json(['success' => true]);
    }

    public function resetRemainingCakeGame()
    {
        // Reset remaining cake game progress
        return redirect()->back();
    }

    // Sentence Game Methods
    public function sentenceGame()
    {
        return view('games.lop4.phanso.sentence');
    }

    public function checkSentenceAnswer(Request $request)
    {
        // Validate and process sentence game answer
        return response()->json(['success' => true]);
    }

    public function resetSentenceGame()
    {
        // Reset sentence game progress
        return redirect()->back();
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

    // Lost City Game Methods
    public function lostCityGame()
    {
        $level = session('lost_city_level', 1);
        $question = $this->generateLostCityQuestion($level);
        return view('games.lop4.phanso.lost_city', compact('question'));
    }

    private function generateLostCityQuestion($level)
    {
        $questions = [
            1 => [
                'streets' => [
                    ['name' => 'Đường số _/2', 'answer' => '1'],
                    ['name' => 'Đường số _/4', 'answer' => '2'],
                    ['name' => 'Đường số _/8', 'answer' => '4']
                ],
                'hint' => 'Điền số thích hợp để tạo các phân số bằng 1/2'
            ],
            2 => [
                'streets' => [
                    ['name' => 'Đường số _/3', 'answer' => '2'],
                    ['name' => 'Đường số _/6', 'answer' => '4'],
                    ['name' => 'Đường số _/9', 'answer' => '6']
                ],
                'hint' => 'Điền số thích hợp để tạo các phân số bằng 2/3'
            ],
            3 => [
                'streets' => [
                    ['name' => 'Đường số _/4', 'answer' => '3'],
                    ['name' => 'Đường số _/8', 'answer' => '6'],
                    ['name' => 'Đường số _/12', 'answer' => '9']
                ],
                'hint' => 'Điền số thích hợp để tạo các phân số bằng 3/4'
            ],
            4 => [
                'streets' => [
                    ['name' => 'Đường số _/5', 'answer' => '4'],
                    ['name' => 'Đường số _/10', 'answer' => '8'],
                    ['name' => 'Đường số _/15', 'answer' => '12']
                ],
                'hint' => 'Điền số thích hợp để tạo các phân số bằng 4/5'
            ],
            5 => [
                'streets' => [
                    ['name' => 'Đường số _/6', 'answer' => '5'],
                    ['name' => 'Đường số _/12', 'answer' => '10'],
                    ['name' => 'Đường số _/18', 'answer' => '15']
                ],
                'hint' => 'Điền số thích hợp để tạo các phân số bằng 5/6'
            ]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkLostCityAnswer(Request $request)
    {
        $level = session('lost_city_level', 1);
        $question = $this->generateLostCityQuestion($level);
        
        $answers = $request->input('answers', []);
        $correct = true;
        
        foreach ($question['streets'] as $index => $street) {
            if (!isset($answers[$index]) || $answers[$index] !== $street['answer']) {
                $correct = false;
                break;
            }
        }
        
        if ($correct && $level < 5) {
            session(['lost_city_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetLostCityGame()
    {
        session()->forget('lost_city_level');
        return redirect()->route('games.lop4.phanso.lost_city');
    }

    // Equal Groups Game Methods
    public function equalGroupsGame()
    {
        $level = session('equal_groups_level', 1);
        $question = $this->generateEqualGroupsQuestion($level);
        return view('games.lop4.phanso.equal_groups', compact('question'));
    }

    private function generateEqualGroupsQuestion($level)
    {
        $questions = [
            1 => [
                'groups' => [
                    ['value' => '1/2', 'fractions' => ['2/4', '3/6', '4/8']],
                    ['value' => '1/3', 'fractions' => ['2/6', '3/9', '4/12']]
                ],
                'hint' => 'Kéo các phân số vào nhóm tương ứng'
            ],
            2 => [
                'groups' => [
                    ['value' => '2/3', 'fractions' => ['4/6', '6/9', '8/12']],
                    ['value' => '3/4', 'fractions' => ['6/8', '9/12', '12/16']]
                ],
                'hint' => 'Kéo các phân số vào nhóm tương ứng'
            ],
            3 => [
                'groups' => [
                    ['value' => '3/5', 'fractions' => ['6/10', '9/15', '12/20']],
                    ['value' => '4/6', 'fractions' => ['8/12', '12/18', '16/24']]
                ],
                'hint' => 'Kéo các phân số vào nhóm tương ứng'
            ],
            4 => [
                'groups' => [
                    ['value' => '5/6', 'fractions' => ['10/12', '15/18', '20/24']],
                    ['value' => '5/8', 'fractions' => ['10/16', '15/24', '20/32']]
                ],
                'hint' => 'Kéo các phân số vào nhóm tương ứng'
            ],
            5 => [
                'groups' => [
                    ['value' => '7/8', 'fractions' => ['14/16', '21/24', '28/32']],
                    ['value' => '7/9', 'fractions' => ['14/18', '21/27', '28/36']]
                ],
                'hint' => 'Kéo các phân số vào nhóm tương ứng'
            ]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkEqualGroupsAnswer(Request $request)
    {
        $level = session('equal_groups_level', 1);
        $question = $this->generateEqualGroupsQuestion($level);
        
        $groups = $request->input('groups', []);
        $correct = true;
        
        foreach ($question['groups'] as $index => $group) {
            if (!isset($groups[$index])) {
                $correct = false;
                break;
            }
            
            foreach ($groups[$index] as $fraction) {
                if (!$this->areFractionsEqual($fraction, $group['value'])) {
                    $correct = false;
                    break 2;
                }
            }
        }
        
        if ($correct && $level < 5) {
            session(['equal_groups_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetEqualGroupsGame()
    {
        session()->forget('equal_groups_level');
        return redirect()->route('games.lop4.phanso.equal_groups');
    }

    // Helper method for checking equivalent fractions
    private function checkEquivalentFractions($fractions, $target)
    {
        foreach ($fractions as $fraction) {
            if (!$this->areFractionsEqual($fraction, $target)) {
                return false;
            }
        }
        return true;
    }

    private function areFractionsEqual($fraction1, $fraction2)
    {
        list($num1, $den1) = explode('/', $fraction1);
        list($num2, $den2) = explode('/', $fraction2);
        
        $value1 = $num1 / $den1;
        $value2 = $num2 / $den2;
        
        return abs($value1 - $value2) < 0.000001;
    }
} 