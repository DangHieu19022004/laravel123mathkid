<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HinhHocGameController extends Controller
{
    public function areaCalculationGame()
    {
        $level = session('area_calculation_level', 1);
        $question = $this->generateAreaCalculationQuestion($level);
        return view('games.lop4.bi_an_hinh_hoc.area_calculation', compact('question'));
    }
    private function generateAreaCalculationQuestion($level)
    {
        $questions = [
            1 => [ 'shape' => 'hình vuông', 'dimensions' => ['cạnh' => 5], 'unit' => 'cm²'],
            2 => [ 'shape' => 'hình chữ nhật', 'dimensions' => ['chiều dài' => 6, 'chiều rộng' => 4], 'unit' => 'cm²'],
            3 => [ 'shape' => 'tam giác', 'dimensions' => ['đáy' => 6, 'chiều cao' => 4], 'unit' => 'cm²'],
            4 => [ 'shape' => 'hình thang', 'dimensions' => ['đáy lớn' => 8, 'đáy nhỏ' => 6, 'chiều cao' => 4], 'unit' => 'cm²'],
            5 => [ 'shape' => 'hình bình hành', 'dimensions' => ['đáy' => 7, 'chiều cao' => 5], 'unit' => 'cm²']
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }
    public function perimeterCalculationGame()
    {
        $level = session('perimeter_calculation_level', 1);
        $question = $this->generatePerimeterCalculationQuestion($level);
        return view('games.lop4.bi_an_hinh_hoc.perimeter_calculation', compact('question'));
    }
    private function generatePerimeterCalculationQuestion($level)
    {
        $questions = [
            1 => [ 'shape' => 'hình vuông', 'sides' => [5], 'unit' => 'cm'],
            2 => [ 'shape' => 'hình chữ nhật', 'sides' => [4, 6], 'unit' => 'cm'],
            3 => [ 'shape' => 'tam giác đều', 'sides' => [8], 'unit' => 'cm'],
            4 => [ 'shape' => 'hình thang', 'sides' => [5, 7, 3, 3], 'unit' => 'cm'],
            5 => [ 'shape' => 'ngũ giác đều', 'sides' => [6], 'unit' => 'cm']
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }
    public function volumeMeasurementGame()
    {
        $question = $this->generateCompareVolumeQuestion();
        return view('games.lop4.bi_an_hinh_hoc.volume_measurement', compact('question'));
    }
    private function generateCompareVolumeQuestion()
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
        shuffle($allObjects);
        $num = rand(2, 3);
        $objects = array_slice($allObjects, 0, $num);
        foreach ($objects as &$o) {
            if ($o['unit'] === 'l') $o['volume_ml'] = $o['volume'] * 1000;
            else $o['volume_ml'] = $o['volume'];
        }
        unset($o);
        $type = rand(0, 1) ? 'max' : 'min';
        $answer_index = 0;
        if ($type === 'max') {
            $max = max(array_column($objects, 'volume_ml'));
            foreach ($objects as $i => $o) if ($o['volume_ml'] == $max) $answer_index = $i;
        } else {
            $min = min(array_column($objects, 'volume_ml'));
            foreach ($objects as $i => $o) if ($o['volume_ml'] == $min) $answer_index = $i;
        }
        $level = session('volume_measurement_level', 1);
        return [
            'objects' => $objects,
            'type' => $type,
            'answer_index' => $answer_index,
            'level' => $level
        ];
    }
    public function angleMeasurementGame()
    {
        $level = session('angle_measurement_level', 1);
        $question = $this->generateAngleMeasurementQuestion($level);
        return view('games.lop4.bi_an_hinh_hoc.angle_measurement', compact('question'));
    }
    private function generateAngleMeasurementQuestion($level)
    {
        $questions = [
            1 => [ 'angle_type' => 'góc vuông', 'actual_angle' => 90, 'tolerance' => 5],
            2 => [ 'angle_type' => 'góc nhọn', 'actual_angle' => 45, 'tolerance' => 5],
            3 => [ 'angle_type' => 'góc tù', 'actual_angle' => 135, 'tolerance' => 5],
            4 => [ 'angle_type' => 'góc bẹt', 'actual_angle' => 180, 'tolerance' => 5],
            5 => [ 'angle_type' => 'góc tự do', 'actual_angle' => 75, 'tolerance' => 5]
        ];
        $question = $questions[$level] ?? $questions[1];
        $question['level'] = $level;
        return $question;
    }
} 