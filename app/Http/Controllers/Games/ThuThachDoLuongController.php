<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThuThachDoLuongController extends Controller
{
    // 15. Thời Gian Nâng Cao Game
    public function advancedTimeGame()
    {
        $level = session('advanced_time_level', 1);
        $question = $this->generateAdvancedTimeQuestion($level);
        return view('games.lop4.dailuongvadoluong.advanced_time', compact('question'));
    }

    private function generateAdvancedTimeQuestion($level)
    {
        $questions = [
            1 => [
                'scenario' => 'Một chuyến xe khởi hành lúc 8:30 và đến nơi lúc 10:15. Hỏi chuyến xe đi mất bao lâu?',
                'start_time' => '8:30',
                'end_time' => '10:15',
                'answer_unit' => 'phút'
            ],
            2 => [
                'scenario' => 'Một buổi học kéo dài 2 giờ 15 phút, bắt đầu từ 13:45. Hỏi buổi học kết thúc lúc mấy giờ?',
                'start_time' => '13:45',
                'duration' => 135,
                'answer_unit' => 'time'
            ],
            3 => [
                'scenario' => 'Một cuộc họp bắt đầu lúc 9:30 và kết thúc lúc 11:45. Tính thời gian cuộc họp?',
                'start_time' => '9:30',
                'end_time' => '11:45',
                'answer_unit' => 'phút'
            ],
            4 => [
                'scenario' => 'Một trận bóng đá kéo dài 2 giờ 30 phút (bao gồm giờ giải lao), bắt đầu lúc 19:00. Hỏi trận đấu kết thúc lúc mấy giờ?',
                'start_time' => '19:00',
                'duration' => 150,
                'answer_unit' => 'time'
            ],
            5 => [
                'scenario' => 'Một chuyến bay xuất phát lúc 23:45 và hạ cánh lúc 5:30 sáng hôm sau. Hỏi chuyến bay kéo dài bao lâu?',
                'start_time' => '23:45',
                'end_time' => '5:30',
                'next_day' => true,
                'answer_unit' => 'phút'
            ]
        ];

        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkAdvancedTimeAnswer(Request $request)
    {
        $level = session('advanced_time_level', 1);
        $question = $this->generateAdvancedTimeQuestion($level);
        
        $answer = $request->input('answer');
        $correct = false;

        if ($question['answer_unit'] === 'phút') {
            $duration = $this->calculateTimeDifference(
                $question['start_time'],
                $question['end_time'],
                $question['next_day'] ?? false
            );
            $correct = $answer == $duration;
        } else {
            $endTime = $this->addMinutesToTime($question['start_time'], $question['duration']);
            $correct = $answer === $endTime;
        }
        
        if ($correct && $level < 5) {
            session(['advanced_time_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }
    // 1. Cân Táo Cân Cam Game
    public function fruitWeighingGame()
    {
        $level = session('fruit_weighing_level', 1);
        $question = $this->generateFruitWeighingQuestion($level);
        return view('games.lop4.dailuongvadoluong.can_tao_cam', compact('question'));
    }

    private function generateFruitWeighingQuestion($level)
    {
        $questions = [
            1 => [
                'leftFruit' => ['type' => 'apple', 'weight' => 150],
                'rightFruit' => ['type' => 'orange', 'weight' => 130],
                'units' => 'g'
            ],
            2 => [
                'leftFruit' => ['type' => 'apple', 'weight' => 0.2],
                'rightFruit' => ['type' => 'orange', 'weight' => 0.18],
                'units' => 'kg'
            ],
            3 => [
                'leftFruit' => ['type' => 'apple', 'weight' => 180],
                'rightFruit' => ['type' => 'orange', 'weight' => 200],
                'units' => 'g'
            ],
            4 => [
                'leftFruit' => ['type' => 'apple', 'weight' => 0.25],
                'rightFruit' => ['type' => 'orange', 'weight' => 0.22],
                'units' => 'kg'
            ],
            5 => [
                'leftFruit' => ['type' => 'apple', 'weight' => 220],
                'rightFruit' => ['type' => 'orange', 'weight' => 180],
                'units' => 'g'
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkFruitWeighingAnswer(Request $request)
    {
        $level = session('fruit_weighing_level', 1);
        $question = $this->generateFruitWeighingQuestion($level);
        
        $answer = $request->input('answer');
        $correct = false;
        
        if ($question['leftFruit']['weight'] > $question['rightFruit']['weight']) {
            $correct = $answer === 'left';
        } elseif ($question['leftFruit']['weight'] < $question['rightFruit']['weight']) {
            $correct = $answer === 'right';
        } else {
            $correct = $answer === 'equal';
        }
        
        if ($correct && $level < 5) {
            session(['fruit_weighing_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetFruitWeighingGame()
    {
        session()->forget('fruit_weighing_level');
        return redirect()->route('games.lop4.dailuongvadoluong.fruit_weighing');
    }
    // 3. Chuyển Đổi Đơn Vị Thần Tốc Game
    public function unitConversionGame()
    {
        $level = session('unit_conversion_level', 1);
        $question = $this->generateUnitConversionQuestion($level);
        return view('games.lop4.dailuongvadoluong.chuyen_doi_don_vi', compact('question'));
    }

    private function generateUnitConversionQuestion($level)
    {
        $questions = [
            1 => [
                'value' => 2000,
                'fromUnit' => 'm',
                'toUnit' => 'km',
                'options' => [1, 2, 3, 4]
            ],
            2 => [
                'value' => 3.5,
                'fromUnit' => 'kg',
                'toUnit' => 'g',
                'options' => [3500, 350, 35, 3050]
            ],
            3 => [
                'value' => 4500,
                'fromUnit' => 'ml',
                'toUnit' => 'l',
                'options' => [4.5, 45, 0.45, 450]
            ],
            4 => [
                'value' => 7.2,
                'fromUnit' => 'km',
                'toUnit' => 'm',
                'options' => [720, 7200, 72, 7020]
            ],
            5 => [
                'value' => 2500,
                'fromUnit' => 'g',
                'toUnit' => 'kg',
                'options' => [2.5, 25, 0.25, 250]
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkUnitConversionAnswer(Request $request)
    {
        $level = session('unit_conversion_level', 1);
        $question = $this->generateUnitConversionQuestion($level);
        
        $answer = $request->input('answer');
        $correct = $this->convertUnit($question['value'], $question['fromUnit'], $question['toUnit']) == $answer;
        
        if ($correct && $level < 5) {
            session(['unit_conversion_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    private function convertUnit($value, $fromUnit, $toUnit)
    {
        $conversions = [
            'm_km' => 0.001,
            'km_m' => 1000,
            'g_kg' => 0.001,
            'kg_g' => 1000,
            'ml_l' => 0.001,
            'l_ml' => 1000
        ];
        
        $key = "{$fromUnit}_{$toUnit}";
        return $value * $conversions[$key];
    }

    public function resetUnitConversionGame()
    {
        session()->forget('unit_conversion_level');
        return redirect()->route('games.lop4.dailuongvadoluong.unit_conversion');
    }
    // 7. Bảng Quy Đổi Game
    public function conversionTableGame()
    {
        $level = session('conversion_table_level', 1);
        $question = $this->generateConversionTableQuestion($level);
        return view('games.lop4.dailuongvadoluong.conversion_table', compact('question'));
    }

    private function generateConversionTableQuestion($level)
    {
        $questions = [
            1 => [
                'type' => 'length',
                'values' => [
                    ['value' => 2, 'unit' => 'km'],
                    ['value' => 3500, 'unit' => 'm'],
                    ['value' => 4200, 'unit' => 'm'],
                    ['value' => 1.8, 'unit' => 'km']
                ],
                'target_unit' => 'm'
            ],
            2 => [
                'type' => 'weight',
                'values' => [
                    ['value' => 1.5, 'unit' => 'kg'],
                    ['value' => 2800, 'unit' => 'g'],
                    ['value' => 3.2, 'unit' => 'kg'],
                    ['value' => 1600, 'unit' => 'g']
                ],
                'target_unit' => 'g'
            ],
            3 => [
                'type' => 'volume',
                'values' => [
                    ['value' => 2.5, 'unit' => 'l'],
                    ['value' => 1800, 'unit' => 'ml'],
                    ['value' => 3400, 'unit' => 'ml'],
                    ['value' => 4.2, 'unit' => 'l']
                ],
                'target_unit' => 'ml'
            ],
            4 => [
                'type' => 'mixed',
                'values' => [
                    ['value' => 1.2, 'unit' => 'km'],
                    ['value' => 2.5, 'unit' => 'kg'],
                    ['value' => 3000, 'unit' => 'ml'],
                    ['value' => 4500, 'unit' => 'm']
                ],
                'conversions' => [
                    'km' => ['to' => 'm', 'multiplier' => 1000],
                    'kg' => ['to' => 'g', 'multiplier' => 1000],
                    'l' => ['to' => 'ml', 'multiplier' => 1000]
                ]
            ],
            5 => [
                'type' => 'mixed',
                'values' => [
                    ['value' => 2800, 'unit' => 'g'],
                    ['value' => 3.6, 'unit' => 'km'],
                    ['value' => 4.2, 'unit' => 'l'],
                    ['value' => 5500, 'unit' => 'm']
                ],
                'conversions' => [
                    'g' => ['to' => 'kg', 'multiplier' => 0.001],
                    'm' => ['to' => 'km', 'multiplier' => 0.001],
                    'ml' => ['to' => 'l', 'multiplier' => 0.001]
                ]
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkConversionTableAnswer(Request $request)
    {
        $level = session('conversion_table_level', 1);
        $question = $this->generateConversionTableQuestion($level);
        
        $answers = json_decode($request->input('answers'), true);
        $correct = true;
        
        foreach ($answers as $index => $answer) {
            $value = $question['values'][$index];
            $converted = $this->convertMeasurement(
                $value['value'],
                $value['unit'],
                $question['target_unit'] ?? $question['conversions'][$value['unit']]['to']
            );
            
            if (abs($converted - $answer) > 0.01) {
                $correct = false;
                break;
            }
        }
        
        if ($correct && $level < 5) {
            session(['conversion_table_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    private function convertMeasurement($value, $fromUnit, $toUnit)
    {
        $conversions = [
            'km_m' => 1000,
            'm_km' => 0.001,
            'kg_g' => 1000,
            'g_kg' => 0.001,
            'l_ml' => 1000,
            'ml_l' => 0.001
        ];
        
        $key = "{$fromUnit}_{$toUnit}";
        return $value * ($conversions[$key] ?? 1);
    }

    public function resetConversionTableGame()
    {
        session()->forget('conversion_table_level');
        return redirect()->route('games.lop4.dailuongvadoluong.conversion_table');
    }
    // 4. Cuộc Đua Đơn Vị Đo Game
    public function distanceComparisonGame()
    {
        $level = session('distance_comparison_level', 1);
        $question = $this->generateDistanceComparisonQuestion($level);
        return view('games.lop4.dailuongvadoluong.distance-comparison', compact('question'));
    }

    private function generateDistanceComparisonQuestion($level)
    {
        $questions = [
            1 => [
                'distances' => [
                    ['value' => 1.5, 'unit' => 'km'],
                    ['value' => 1200, 'unit' => 'm'],
                    ['value' => 1800, 'unit' => 'm']
                ]
            ],
            2 => [
                'distances' => [
                    ['value' => 2.5, 'unit' => 'km'],
                    ['value' => 2800, 'unit' => 'm'],
                    ['value' => 2300, 'unit' => 'm']
                ]
            ],
            3 => [
                'distances' => [
                    ['value' => 3000, 'unit' => 'm'],
                    ['value' => 3.2, 'unit' => 'km'],
                    ['value' => 2900, 'unit' => 'm']
                ]
            ],
            4 => [
                'distances' => [
                    ['value' => 4.5, 'unit' => 'km'],
                    ['value' => 4800, 'unit' => 'm'],
                    ['value' => 4600, 'unit' => 'm']
                ]
            ],
            5 => [
                'distances' => [
                    ['value' => 5200, 'unit' => 'm'],
                    ['value' => 5.1, 'unit' => 'km'],
                    ['value' => 5300, 'unit' => 'm']
                ]
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkDistanceComparisonAnswer(Request $request)
    {
        $level = session('distance_comparison_level', 1);
        $question = $this->generateDistanceComparisonQuestion($level);
        
        $answer = json_decode($request->input('answer'), true);
        $distances = array_map(function($d) {
            return $this->convertToMeters($d['value'], $d['unit']);
        }, $question['distances']);
        
        $sortedDistances = $distances;
        sort($sortedDistances);
        
        $correct = true;
        foreach ($answer as $index => $position) {
            if ($distances[$position] !== $sortedDistances[$index]) {
                $correct = false;
                break;
            }
        }
        
        if ($correct && $level < 5) {
            session(['distance_comparison_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    private function convertToMeters($value, $unit)
    {
        return $unit === 'km' ? $value * 1000 : $value;
    }

    public function resetDistanceComparisonGame()
    {
        session()->forget('distance_comparison_level');
        return redirect()->route('games.lop4.dailuongvadoluong.distance_comparison');
    }
    // 8. Đo Độ Dài Game
    public function lengthMeasurementGame()
    {
        $question = $this->generateCompareLengthQuestion();
        return view('games.lop4.dailuongvadoluong.compare_length', compact('question'));
    }

    private function generateCompareLengthQuestion()
    {
        $allObjects = [
            ['object' => 'bút chì', 'emoji' => '✏️', 'length' => 15, 'unit' => 'cm'],
            ['object' => 'quyển vở', 'emoji' => '📓', 'length' => 25, 'unit' => 'cm'],
            ['object' => 'thước kẻ', 'emoji' => '📏', 'length' => 30, 'unit' => 'cm'],
            ['object' => 'dây nhảy', 'emoji' => '🪢', 'length' => 2.5, 'unit' => 'm'],
            ['object' => 'điện thoại', 'emoji' => '📱', 'length' => 15, 'unit' => 'cm'],
            ['object' => 'hộp bút', 'emoji' => '🖊️', 'length' => 20, 'unit' => 'cm'],
            ['object' => 'chai nước', 'emoji' => '🧴', 'length' => 22, 'unit' => 'cm'],
            ['object' => 'bàn học', 'emoji' => '🪑', 'length' => 1.2, 'unit' => 'm'],
            ['object' => 'tờ giấy A4', 'emoji' => '📄', 'length' => 29.7, 'unit' => 'cm'],
            ['object' => 'cửa lớp học', 'emoji' => '🚪', 'length' => 2, 'unit' => 'm'],
        ];
        shuffle($allObjects);
        $num = rand(2, 3);
        $objects = array_slice($allObjects, 0, $num);
        // Đổi hết về cm để so sánh
        foreach ($objects as &$o) {
            if ($o['unit'] === 'm') $o['length_cm'] = $o['length'] * 100;
            else $o['length_cm'] = $o['length'];
        }
        unset($o);
        $type = rand(0, 1) ? 'max' : 'min';
        $answer_index = 0;
        if ($type === 'max') {
            $max = max(array_column($objects, 'length_cm'));
            foreach ($objects as $i => $o) if ($o['length_cm'] == $max) $answer_index = $i;
        } else {
            $min = min(array_column($objects, 'length_cm'));
            foreach ($objects as $i => $o) if ($o['length_cm'] == $min) $answer_index = $i;
        }
        return [
            'objects' => $objects,
            'type' => $type,
            'answer_index' => $answer_index
        ];
    }

    public function checkLengthMeasurementAnswer(Request $request)
    {
        // Không dùng level nữa, chỉ kiểm tra đúng/sai
        $actual_length = $request->input('actual_length');
        $tolerance = $request->input('tolerance');
        $answer = $request->input('answer');
        $difference = abs($answer - $actual_length);
        $correct = $difference <= $tolerance;
        return response()->json([
            'correct' => $correct,
            'actual_length' => $actual_length
        ]);
    }

    public function resetLengthMeasurementGame()
    {
        session()->forget('length_measurement_level');
        return redirect()->route('games.lop4.dailuongvadoluong.length_measurement');
    }
    // 6. Bấm Giờ Chuẩn Game
    public function precisionTimingGame()
    {
        $level = session('precision_timing_level', 1);
        $question = $this->generatePrecisionTimingQuestion($level);
        return view('games.lop4.dailuongvadoluong.precision_timing', compact('question'));
    }

    private function generatePrecisionTimingQuestion($level)
    {
        $questions = [
            1 => [
                'targetDuration' => 10,
                'allowedError' => 0.5,
                'description' => 'Bấm giờ đúng 10 giây'
            ],
            2 => [
                'targetDuration' => 20,
                'allowedError' => 0.5,
                'description' => 'Bấm giờ đúng 20 giây'
            ],
            3 => [
                'targetDuration' => 30,
                'allowedError' => 0.7,
                'description' => 'Bấm giờ đúng 30 giây'
            ],
            4 => [
                'targetDuration' => 45,
                'allowedError' => 1,
                'description' => 'Bấm giờ đúng 45 giây'
            ],
            5 => [
                'targetDuration' => 60,
                'allowedError' => 1,
                'description' => 'Bấm giờ đúng 1 phút'
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkPrecisionTimingAnswer(Request $request)
    {
        $level = session('precision_timing_level', 1);
        $question = $this->generatePrecisionTimingQuestion($level);
        
        $duration = $request->input('duration');
        $error = abs($duration - $question['targetDuration']);
        $correct = $error <= $question['allowedError'];
        
        if ($correct && $level < 5) {
            session(['precision_timing_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5,
            'error' => $error
        ]);
    }

    public function resetPrecisionTimingGame()
    {
        session()->forget('precision_timing_level');
        return redirect()->route('games.lop4.dailuongvadoluong.precision_timing');
    }
    // 2. Thời Gian Phiêu Lưu Game
    public function timeAdventureGame()
    {
        $level = session('time_adventure_level', 1);
        $question = $this->generateTimeAdventureQuestion($level);
        return view('games.lop4.dailuongvadoluong.thoi_gian_phieu_luu', compact('question'));
    }

    private function generateTimeAdventureQuestion($level)
    {
        $questions = [
            1 => [
                'startTime' => '08:30',
                'duration' => 45,
                'type' => 'minutes'
            ],
            2 => [
                'startTime' => '10:15',
                'duration' => 2,
                'type' => 'hours'
            ],
            3 => [
                'startTime' => '14:20',
                'duration' => 90,
                'type' => 'minutes'
            ],
            4 => [
                'startTime' => '09:45',
                'duration' => 3.5,
                'type' => 'hours'
            ],
            5 => [
                'startTime' => '16:30',
                'duration' => 150,
                'type' => 'minutes'
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkTimeAdventureAnswer(Request $request)
    {
        $level = session('time_adventure_level', 1);
        $question = $this->generateTimeAdventureQuestion($level);
        
        $answer = $request->input('answer');
        $correct = $this->calculateEndTime($question['startTime'], $question['duration'], $question['type']) === $answer;
        
        if ($correct && $level < 5) {
            session(['time_adventure_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    private function calculateEndTime($startTime, $duration, $type)
    {
        $time = strtotime($startTime);
        if ($type === 'minutes') {
            $time += $duration * 60;
        } else {
            $time += $duration * 3600;
        }
        return date('H:i', $time);
    }

    public function resetTimeAdventureGame()
    {
        session()->forget('time_adventure_level');
        return redirect()->route('games.lop4.dailuongvadoluong.time_adventure');
    }
    // 10. So Sánh Thời Gian Game
    public function timeComparisonGame()
    {
        $level = session('time_comparison_level', 1);
        $question = $this->generateTimeComparisonQuestion($level);
        return view('games.lop4.dailuongvadoluong.time_comparison', compact('question'));
    }

    private function generateTimeComparisonQuestion($level)
    {
        $questions = [
            1 => [
                'times' => [
                    ['hours' => 1, 'minutes' => 30],
                    ['hours' => 2, 'minutes' => 0],
                    ['hours' => 1, 'minutes' => 45]
                ]
            ],
            2 => [
                'times' => [
                    ['hours' => 2, 'minutes' => 15],
                    ['hours' => 2, 'minutes' => 45],
                    ['hours' => 2, 'minutes' => 30]
                ]
            ],
            3 => [
                'times' => [
                    ['hours' => 3, 'minutes' => 0],
                    ['hours' => 2, 'minutes' => 55],
                    ['hours' => 3, 'minutes' => 5]
                ]
            ],
            4 => [
                'times' => [
                    ['hours' => 4, 'minutes' => 30],
                    ['hours' => 4, 'minutes' => 15],
                    ['hours' => 4, 'minutes' => 45]
                ]
            ],
            5 => [
                'times' => [
                    ['hours' => 5, 'minutes' => 25],
                    ['hours' => 5, 'minutes' => 30],
                    ['hours' => 5, 'minutes' => 15]
                ]
            ]
        ];

        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkTimeComparisonAnswer(Request $request)
    {
        $level = session('time_comparison_level', 1);
        $question = $this->generateTimeComparisonQuestion($level);
        
        $answer = $request->input('answer');
        $times = array_map(function($t) {
            return $t['hours'] * 60 + $t['minutes'];
        }, $question['times']);
        
        $sortedTimes = $times;
        sort($sortedTimes);
        
        // Validate answer
        if (!is_array($answer) || count($answer) !== count($times)) {
            return response()->json([
                'correct' => false,
                'error' => 'Dữ liệu gửi lên không hợp lệ (sai số lượng phần tử).'
            ], 200);
        }
        if (count(array_unique($answer)) !== count($answer)) {
            return response()->json([
                'correct' => false,
                'error' => 'Có chỉ số bị lặp lại trong câu trả lời.'
            ], 200);
        }
        foreach ($answer as $idx) {
            if (!is_int($idx) && !ctype_digit(strval($idx))) {
                return response()->json([
                    'correct' => false,
                    'error' => 'Chỉ số không hợp lệ.'
                ], 200);
            }
            $idx = (int)$idx;
            if ($idx < 0 || $idx >= count($times)) {
                return response()->json([
                    'correct' => false,
                    'error' => 'Chỉ số vượt quá số lượng thời gian.'
                ], 200);
            }
        }
        
        $correct = true;
        foreach ($answer as $index => $position) {
            if ($times[$position] !== $sortedTimes[$index]) {
                $correct = false;
                break;
            }
        }
        
        if ($correct && $level < 5) {
            session(['time_comparison_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    public function resetTimeComparisonGame()
    {
        session()->forget('time_comparison_level');
        return redirect()->route('games.lop4.dailuongvadoluong.time_comparison');
    }
    // 9. Ước Lượng Khối Lượng Game
    public function weightEstimationGame()
    {
        $question = $this->generateCompareWeightQuestion();
        return view('games.lop4.dailuongvadoluong.weight_estimation', compact('question'));
    }

    private function generateCompareWeightQuestion()
    {
        $allObjects = [
            ['object' => 'quả táo', 'emoji' => '🍎', 'weight' => 150, 'unit' => 'g'],
            ['object' => 'túi gạo nhỏ', 'emoji' => '🍚', 'weight' => 1, 'unit' => 'kg'],
            ['object' => 'cặp sách', 'emoji' => '🎒', 'weight' => 2.5, 'unit' => 'kg'],
            ['object' => 'xe đạp', 'emoji' => '🚲', 'weight' => 12, 'unit' => 'kg'],
            ['object' => 'bao gạo lớn', 'emoji' => '🧺', 'weight' => 25, 'unit' => 'kg'],
            ['object' => 'quyển sách', 'emoji' => '📕', 'weight' => 300, 'unit' => 'g'],
            ['object' => 'chai nước', 'emoji' => '🧴', 'weight' => 500, 'unit' => 'g'],
            ['object' => 'bút chì', 'emoji' => '✏️', 'weight' => 10, 'unit' => 'g'],
            ['object' => 'hộp sữa', 'emoji' => '🥛', 'weight' => 180, 'unit' => 'g'],
            ['object' => 'quả cam', 'emoji' => '🍊', 'weight' => 200, 'unit' => 'g'],
        ];
        shuffle($allObjects);
        $num = rand(2, 3);
        $objects = array_slice($allObjects, 0, $num);
        // Đổi hết về gam để so sánh
        foreach ($objects as &$o) {
            if ($o['unit'] === 'kg') $o['weight_g'] = $o['weight'] * 1000;
            else $o['weight_g'] = $o['weight'];
        }
        unset($o);
        $type = rand(0, 1) ? 'max' : 'min';
        $answer_index = 0;
        if ($type === 'max') {
            $max = max(array_column($objects, 'weight_g'));
            foreach ($objects as $i => $o) if ($o['weight_g'] == $max) $answer_index = $i;
        } else {
            $min = min(array_column($objects, 'weight_g'));
            foreach ($objects as $i => $o) if ($o['weight_g'] == $min) $answer_index = $i;
        }
        return [
            'objects' => $objects,
            'type' => $type,
            'answer_index' => $answer_index
        ];
    }

    public function checkWeightEstimationAnswer(Request $request)
    {
        $level = session('weight_estimation_level', 1);
        $question = $this->generateWeightEstimationQuestion($level);
        
        $answer = $request->input('answer');
        $difference = abs($answer - $question['actual_weight']);
        $correct = $difference <= $question['tolerance'];
        
        if ($correct && $level < 5) {
            session(['weight_estimation_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5,
            'actual_weight' => $question['actual_weight']
        ]);
    }

    public function resetWeightEstimationGame()
    {
        session()->forget('weight_estimation_level');
        return redirect()->route('games.lop4.dailuongvadoluong.weight_estimation');
    }
    // 5. Xếp Hàng Theo Khối Lượng Game
    public function weightSortingGame()
    {
        $level = session('weight_sorting_level', 1);
        $question = $this->generateWeightSortingQuestion($level);
        return view('games.lop4.dailuongvadoluong.weight_sorting', compact('question'));
    }

    private function generateWeightSortingQuestion($level)
    {
        $questions = [
            1 => [
                'weights' => [
                    ['value' => 500, 'unit' => 'g'],
                    ['value' => 0.7, 'unit' => 'kg'],
                    ['value' => 300, 'unit' => 'g'],
                    ['value' => 0.9, 'unit' => 'kg']
                ]
            ],
            2 => [
                'weights' => [
                    ['value' => 1.2, 'unit' => 'kg'],
                    ['value' => 900, 'unit' => 'g'],
                    ['value' => 1500, 'unit' => 'g'],
                    ['value' => 0.8, 'unit' => 'kg']
                ]
            ],
            3 => [
                'weights' => [
                    ['value' => 2000, 'unit' => 'g'],
                    ['value' => 1.5, 'unit' => 'kg'],
                    ['value' => 2.5, 'unit' => 'kg'],
                    ['value' => 1800, 'unit' => 'g']
                ]
            ],
            4 => [
                'weights' => [
                    ['value' => 3.2, 'unit' => 'kg'],
                    ['value' => 2800, 'unit' => 'g'],
                    ['value' => 3500, 'unit' => 'g'],
                    ['value' => 2.9, 'unit' => 'kg']
                ]
            ],
            5 => [
                'weights' => [
                    ['value' => 4500, 'unit' => 'g'],
                    ['value' => 5, 'unit' => 'kg'],
                    ['value' => 4.2, 'unit' => 'kg'],
                    ['value' => 3800, 'unit' => 'g']
                ]
            ]
        ];
        
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }

    public function checkWeightSortingAnswer(Request $request)
    {
        $level = session('weight_sorting_level', 1);
        $question = $this->generateWeightSortingQuestion($level);
        
        $answer = json_decode($request->input('answer'), true);
        $weights = array_map(function($w) {
            return $this->convertToGrams($w['value'], $w['unit']);
        }, $question['weights']);
        
        $sortedWeights = $weights;
        sort($sortedWeights);
        
        $correct = true;
        foreach ($answer as $index => $position) {
            if ($weights[$position] !== $sortedWeights[$index]) {
                $correct = false;
                break;
            }
        }
        
        if ($correct && $level < 5) {
            session(['weight_sorting_level' => $level + 1]);
        }
        
        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $level < 5
        ]);
    }

    private function convertToGrams($value, $unit)
    {
        return $unit === 'kg' ? $value * 1000 : $value;
    }

    public function resetWeightSortingGame()
    {
        session()->forget('weight_sorting_level');
        return redirect()->route('games.lop4.dailuongvadoluong.weight_sorting');
    }
} 