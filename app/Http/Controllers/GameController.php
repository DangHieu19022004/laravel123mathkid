<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function gameHub()
    {
        return view('games.lop4.phanso', [
            'cakeLevel' => session('cake_level', 1),
            'appleLevel' => session('apple_level', 1),
            'bracketLevel' => session('bracket_level', 1)
        ]);
    }

    public function cakeGame()
    {
        $level = session('cake_level', 1);
        $pieces = 2 + ($level - 1) * 2; // Level 1: 2 pieces, Level 2: 4 pieces, etc.
        
        // Random numerator but ensure it's less than total pieces
        $numerator = rand(1, $pieces - 1);
        
        $question = [
            'level' => $level,
            'pieces' => $pieces,
            'numerator' => $numerator,
            'denominator' => $pieces
        ];
        
        return view('games.lop4.cake', compact('question'));
    }

    public function appleGame()
    {
        $level = session('apple_level', 1);
        
        // Generate random apple counts based on level
        switch($level) {
            case 1:
                $totalApples = rand(4, 8);
                $groups = 2;
                break;
            case 2:
                $totalApples = rand(6, 12);
                $groups = 2;
                break;
            case 3:
                $totalApples = rand(9, 15);
                $groups = 3;
                break;
            case 4:
                $totalApples = rand(12, 20);
                $groups = 3;
                break;
            case 5:
                $totalApples = rand(16, 24);
                $groups = 4;
                break;
            default:
                $totalApples = rand(4, 8);
                $groups = 2;
        }
        
        // Ensure totalApples is divisible by groups
        $totalApples = floor($totalApples / $groups) * $groups;
        
        $question = [
            'level' => $level,
            'totalApples' => $totalApples,
            'groups' => $groups
        ];
        
        return view('games.lop4.apple', compact('question'));
    }

    public function bracketGame()
    {
        $level = session('bracket_level', 1);
        
        $expression = '';
        $correctAnswer = 0;
        
        switch($level) {
            case 1:
                // Simple brackets: (a + b) × c or (a × b) + c
                $a = rand(1, 5);
                $b = rand(1, 5);
                $c = rand(2, 4);
                if (rand(0, 1)) {
                    $expression = "($a + $b) × $c";
                    $correctAnswer = ($a + $b) * $c;
                } else {
                    $expression = "($a × $b) + $c";
                    $correctAnswer = ($a * $b) + $c;
                }
                break;
                
            case 2:
                // Nested brackets: (a + (b × c)) or ((a × b) + c)
                $a = rand(1, 3);
                $b = rand(1, 3);
                $c = rand(2, 4);
                if (rand(0, 1)) {
                    $expression = "($a + ($b × $c))";
                    $correctAnswer = $a + ($b * $c);
                } else {
                    $expression = "(($a × $b) + $c)";
                    $correctAnswer = ($a * $b) + $c;
                }
                break;
                
            case 3:
                // Multiple operations: (a × b) + (c × d) or (a + b) × (c + d)
                $a = rand(1, 3);
                $b = rand(2, 4);
                $c = rand(2, 4);
                $d = rand(1, 3);
                if (rand(0, 1)) {
                    $expression = "($a × $b) + ($c × $d)";
                    $correctAnswer = ($a * $b) + ($c * $d);
                } else {
                    $expression = "($a + $b) × ($c + $d)";
                    $correctAnswer = ($a + $b) * ($c + $d);
                }
                break;
                
            case 4:
                // Mixed operations with subtraction: (a + b) × (c - d) or (a × b) - (c × d)
                $a = rand(2, 4);
                $b = rand(1, 3);
                $c = rand(4, 6);
                $d = rand(1, 3);
                if (rand(0, 1)) {
                    $expression = "($a + $b) × ($c - $d)";
                    $correctAnswer = ($a + $b) * ($c - $d);
                } else {
                    $expression = "($a × $b) - ($c × $d)";
                    $correctAnswer = ($a * $b) - ($c * $d);
                }
                break;
                
            case 5:
                // Complex expressions with multiple operations
                $a = rand(1, 3);
                $b = rand(2, 4);
                $c = rand(2, 3);
                $d = rand(1, 2);
                $operations = [
                    ["(($a + $b) × $c) + $d", (($a + $b) * $c) + $d],
                    ["($a × ($b + $c)) - $d", ($a * ($b + $c)) - $d],
                    ["($a + $b) × ($c + $d)", ($a + $b) * ($c + $d)],
                    ["($a × $b) + ($c × $d)", ($a * $b) + ($c * $d)]
                ];
                $selected = $operations[array_rand($operations)];
                $expression = $selected[0];
                $correctAnswer = $selected[1];
                break;
        }
        
        // Generate wrong options that are close to correct answer
        $options = [$correctAnswer];
        while (count($options) < 4) {
            $wrong = $correctAnswer + rand(-3, 3);
            if ($wrong != $correctAnswer && !in_array($wrong, $options)) {
                $options[] = $wrong;
            }
        }
        shuffle($options);
        
        $question = [
            'level' => $level,
            'expression' => $expression,
            'options' => $options,
            'correctAnswer' => $correctAnswer
        ];
        
        return view('games.lop4.bracket', compact('question'));
    }

    public function checkCakeAnswer(Request $request)
    {
        $level = session('cake_level', 1);
        $selectedPieces = json_decode($request->input('selected_pieces'), true);
        $numerator = $request->input('numerator');
        
        if (!is_array($selectedPieces)) {
            return response()->json([
                'correct' => false,
                'error' => 'Dữ liệu không hợp lệ'
            ]);
        }
        
        $isCorrect = count($selectedPieces) === (int)$numerator;
        
        if ($isCorrect) {
            if ($level < 5) {
                session(['cake_level' => $level + 1]);
            } else {
                session()->forget('cake_level');
            }
        }
        
        return response()->json([
            'correct' => $isCorrect,
            'next_level' => $isCorrect && $level < 5 ? $level + 1 : null
        ]);
    }

    public function checkChiataoAnswer(Request $request)
    {
        $level = session('apple_level', 1);
        $groupCounts = json_decode($request->input('group_counts'), true);
        $totalApples = (int)$request->input('totalApples');
        $groups = (int)$request->input('groups');

        if (!is_array($groupCounts)) {
            return response()->json([
                'correct' => false,
                'error' => 'Dữ liệu không hợp lệ'
            ]);
        }

        $isCorrect = count($groupCounts) === $groups &&
                    array_sum($groupCounts) === $totalApples &&
                    count(array_unique($groupCounts)) === 1;

        if ($isCorrect) {
            if ($level < 5) {
                session(['apple_level' => $level + 1]);
            } else {
                session()->forget('apple_level');
            }
        }

        return response()->json([
            'correct' => $isCorrect,
            'next_level' => $isCorrect && $level < 5 ? $level + 1 : null
        ]);
    }

    public function checkBieuthucAnswer(Request $request)
    {
        $level = session('bracket_level', 1);
        $selectedAnswer = $request->input('selected_answer');
        $correctAnswer = $request->input('correct_answer');

        $isCorrect = (int)$selectedAnswer === (int)$correctAnswer;

        if ($isCorrect) {
            if ($level < 5) {
                session(['bracket_level' => $level + 1]);
            } else {
                session()->forget('bracket_level');
            }
        }

        return response()->json([
            'correct' => $isCorrect,
            'next_level' => $isCorrect && $level < 5 ? $level + 1 : null
        ]);
    }

    public function resetCakeGame(Request $request)
    {
        session()->forget('cake_level');
        return redirect()->route('games.lop4.phanso.cake');
    }

    public function resetAppleGame(Request $request)
    {
        session()->forget('apple_level');
        return redirect()->route('games.lop4.phanso.apple');
    }

    public function resetBracketGame(Request $request)
    {
        session()->forget('bracket_level');
        return redirect()->route('games.lop4.phanso.bracket');
    }
} 