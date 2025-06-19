<?php

namespace App\Http\Controllers\Games;

use Illuminate\Http\Request;

class HinhHocGameController extends AbstractGroupGameController
{
    protected string $group = 'bi_an_hinh_hoc';

    public function areaCalculationGame()
    {
        $allQuestions = [
            ['shape' => 'hình vuông', 'dimensions' => ['cạnh' => 5], 'unit' => 'cm²'],
            ['shape' => 'hình chữ nhật', 'dimensions' => ['chiều dài' => 6, 'chiều rộng' => 4], 'unit' => 'cm²'],
            ['shape' => 'tam giác', 'dimensions' => ['đáy' => 6, 'chiều cao' => 4], 'unit' => 'cm²'],
            [
                'shape' => 'hình thang', 'dimensions' => ['đáy lớn' => 8, 'đáy nhỏ' => 6, 'chiều cao' => 4],
                'unit'  => 'cm²'
            ],
            ['shape' => 'hình bình hành', 'dimensions' => ['đáy' => 7, 'chiều cao' => 5], 'unit' => 'cm²'],
            ['shape' => 'hình vuông', 'dimensions' => ['cạnh' => 9], 'unit' => 'cm²'],
            ['shape' => 'hình chữ nhật', 'dimensions' => ['chiều dài' => 10, 'chiều rộng' => 3], 'unit' => 'cm²'],
            ['shape' => 'tam giác', 'dimensions' => ['đáy' => 12, 'chiều cao' => 5], 'unit' => 'cm²'],
            [
                'shape' => 'hình thang', 'dimensions' => ['đáy lớn' => 14, 'đáy nhỏ' => 8, 'chiều cao' => 6],
                'unit'  => 'cm²'
            ],
            ['shape' => 'hình bình hành', 'dimensions' => ['đáy' => 11, 'chiều cao' => 7], 'unit' => 'cm²'],
        ];
        shuffle($allQuestions);
        $questions = array_slice($allQuestions, 0, 5);
        foreach ($questions as $i => &$q) {
            $q['level'] = $i + 1;
        }
        unset($q);
        return view('games.lop4.bi_an_hinh_hoc.area_calculation', compact('questions'));
    }

    public function perimeterCalculationGame()
    {
        $allQuestions = [
            ['shape' => 'hình vuông', 'sides' => [5], 'unit' => 'cm'],
            ['shape' => 'hình chữ nhật', 'sides' => [4, 6], 'unit' => 'cm'],
            ['shape' => 'tam giác đều', 'sides' => [8], 'unit' => 'cm'],
            ['shape' => 'hình thang', 'sides' => [5, 7, 3, 3], 'unit' => 'cm'],
            ['shape' => 'ngũ giác đều', 'sides' => [6], 'unit' => 'cm'],
            ['shape' => 'hình vuông', 'sides' => [9], 'unit' => 'cm'],
            ['shape' => 'hình chữ nhật', 'sides' => [10, 3], 'unit' => 'cm'],
            ['shape' => 'tam giác đều', 'sides' => [12], 'unit' => 'cm'],
            ['shape' => 'hình thang', 'sides' => [14, 8, 6, 6], 'unit' => 'cm'],
            ['shape' => 'ngũ giác đều', 'sides' => [11], 'unit' => 'cm'],
        ];
        shuffle($allQuestions);
        $questions = array_slice($allQuestions, 0, 5);
        foreach ($questions as $i => &$q) {
            $q['level'] = $i + 1;
        }
        unset($q);
        return view('games.lop4.bi_an_hinh_hoc.perimeter_calculation', compact('questions'));
    }

    public function volumeMeasurementGame()
    {
        $uniqueQuestions = [];
        $maxTries        = 100;
        $tries           = 0;
        while (count($uniqueQuestions) < 10 && $tries < $maxTries) {
            $q = $this->generateCompareVolumeQuestion();
            // Tạo key duy nhất cho câu hỏi dựa trên object và type
            $key = $q['type'].':'.implode('-', array_map(function ($o) {
                    return $o['object'];
                }, $q['objects']));
            if (!isset($uniqueQuestions[$key])) {
                $uniqueQuestions[$key] = $q;
            }
            $tries++;
        }
        // Lấy ngẫu nhiên 5 câu trong 10 câu không trùng
        $allQuestions = array_values($uniqueQuestions);
        shuffle($allQuestions);
        $questions = array_slice($allQuestions, 0, 5);
        return view('games.lop4.bi_an_hinh_hoc.volume_measurement', compact('questions'));
    }

    private function generateCompareVolumeQuestion(): array
    {
        $allObjects = [
            ['object' => 'ly nước', 'emoji' => '🥛', 'volume' => 250, 'unit' => 'ml'],
            ['object' => 'chai nước', 'emoji' => '🧴', 'volume' => 1.5, 'unit' => 'l'],
            ['object' => 'xô nước', 'emoji' => '🪣', 'volume' => 10, 'unit' => 'l'],
            ['object' => 'bể cá nhỏ', 'emoji' => '🐟', 'volume' => 20, 'unit' => 'l'],
            ['object' => 'thùng nước lớn', 'emoji' => '🛢️', 'volume' => 100, 'unit' => 'l'],
            ['object' => 'cốc trà sữa', 'emoji' => '🧋', 'volume' => 500, 'unit' => 'ml'],
            ['object' => 'bình nước', 'emoji' => '🚰', 'volume' => 2, 'unit' => 'l'],
            ['object' => 'lọ hoa', 'emoji' => '🏺', 'volume' => 800, 'unit' => 'ml'],
            ['object' => 'bình thủy tinh', 'emoji' => '🍶', 'volume' => 1, 'unit' => 'l'],
            ['object' => 'bình sữa', 'emoji' => '🍼', 'volume' => 200, 'unit' => 'ml'],
        ];
        do {
            shuffle($allObjects);
            $num     = rand(2, 3);
            $objects = array_slice($allObjects, 0, $num);
            foreach ($objects as &$o) {
                if ($o['unit'] === 'l') {
                    $o['volume_ml'] = $o['volume'] * 1000;
                } else {
                    $o['volume_ml'] = $o['volume'];
                }
            }
            unset($o);
            // Kiểm tra trùng giá trị volume_ml
            $vols = array_column($objects, 'volume_ml');
        } while (count(array_unique($vols)) < count($vols));

        $type         = rand(0, 1) ? 'max' : 'min';
        $answer_index = 0;
        if ($type === 'max') {
            $max = max($vols);
            foreach ($objects as $i => $o) {
                if ($o['volume_ml'] == $max) {
                    $answer_index = $i;
                    break;
                }
            }
        } else {
            $min = min($vols);
            foreach ($objects as $i => $o) {
                if ($o['volume_ml'] == $min) {
                    $answer_index = $i;
                    break;
                }
            }
        }
        return [
            'objects'      => $objects,
            'type'         => $type,
            'answer_index' => $answer_index
        ];
    }

    public function angleMeasurementGame()
    {
        $allQuestions = [
            ['angle_type' => 'góc vuông', 'actual_angle' => 90, 'tolerance' => 5],
            ['angle_type' => 'góc nhọn', 'actual_angle' => 45, 'tolerance' => 5],
            ['angle_type' => 'góc tù', 'actual_angle' => 135, 'tolerance' => 5],
            ['angle_type' => 'góc bẹt', 'actual_angle' => 180, 'tolerance' => 5],
            ['angle_type' => 'góc tự do', 'actual_angle' => 75, 'tolerance' => 5],
            ['angle_type' => 'góc nhọn', 'actual_angle' => 30, 'tolerance' => 5],
            ['angle_type' => 'góc tù', 'actual_angle' => 120, 'tolerance' => 5],
            ['angle_type' => 'góc vuông', 'actual_angle' => 90, 'tolerance' => 3],
            ['angle_type' => 'góc bẹt', 'actual_angle' => 180, 'tolerance' => 3],
            ['angle_type' => 'góc nhọn', 'actual_angle' => 60, 'tolerance' => 5],
        ];
        shuffle($allQuestions);
        $questions = array_slice($allQuestions, 0, 5);
        foreach ($questions as $i => &$q) {
            $q['level'] = $i + 1;
        }
        unset($q);
        return view('games.lop4.bi_an_hinh_hoc.angle_measurement', compact('questions'));
    }
}
