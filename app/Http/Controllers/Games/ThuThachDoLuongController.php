<?php

namespace App\Http\Controllers\Games;

use Random\RandomException;

class ThuThachDoLuongController extends AbstractGroupGameController
{
    protected string $group = 'thu_thach_do_luong';

    // 1. Thời Gian Nâng Cao
    public function advancedTimeGame()
    {
        $questions = [
            [
                'level'       => 1,
                'scenario'    => 'Một chuyến xe khởi hành lúc 8:30 và đến nơi lúc 10:15. Hỏi chuyến xe đi mất bao lâu?',
                'start_time'  => '8:30',
                'end_time'    => '10:15',
                'answer_unit' => 'phút'
            ],
            [
                'level'       => 2,
                'scenario'    => 'Một buổi học kéo dài 2 giờ 15 phút, bắt đầu từ 13:45. Hỏi buổi học kết thúc lúc mấy giờ?',
                'start_time'  => '13:45',
                'duration'    => 135,
                'answer_unit' => 'time'
            ],
            [
                'level'       => 3,
                'scenario'    => 'Một cuộc họp bắt đầu lúc 9:30 và kết thúc lúc 11:45. Tính thời gian cuộc họp?',
                'start_time'  => '9:30',
                'end_time'    => '11:45',
                'answer_unit' => 'phút'
            ],
            [
                'level'       => 4,
                'scenario'    => 'Một trận bóng đá kéo dài 2 giờ 30 phút (bao gồm giờ giải lao), bắt đầu lúc 19:00. Hỏi trận đấu kết thúc lúc mấy giờ?',
                'start_time'  => '19:00',
                'duration'    => 150,
                'answer_unit' => 'time'
            ],
            [
                'level'       => 5,
                'scenario'    => 'Một chuyến bay xuất phát lúc 23:45 và hạ cánh lúc 5:30 sáng hôm sau. Hỏi chuyến bay kéo dài bao lâu?',
                'start_time'  => '23:45',
                'end_time'    => '5:30',
                'next_day'    => true,
                'answer_unit' => 'phút'
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.advanced_time', ['questions' => $questions]);
    }

    // 2. Cân Táo Cân Cam
    public function fruitWeighingGame()
    {
        $questions = [
            [
                'leftFruit'  => ['type' => 'apple', 'weight' => 150],
                'rightFruit' => ['type' => 'orange', 'weight' => 130],
                'units'      => 'g'
            ],
            [
                'leftFruit'  => ['type' => 'apple', 'weight' => 0.2],
                'rightFruit' => ['type' => 'orange', 'weight' => 0.18],
                'units'      => 'kg'
            ],
            [
                'leftFruit'  => ['type' => 'apple', 'weight' => 180],
                'rightFruit' => ['type' => 'orange', 'weight' => 200],
                'units'      => 'g'
            ],
            [
                'leftFruit'  => ['type' => 'apple', 'weight' => 0.25],
                'rightFruit' => ['type' => 'orange', 'weight' => 0.22],
                'units'      => 'kg'
            ],
            [
                'leftFruit'  => ['type' => 'apple', 'weight' => 220],
                'rightFruit' => ['type' => 'orange', 'weight' => 180],
                'units'      => 'g'
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.can_tao_cam', ['questions' => $questions]);
    }

    // 3. Chuyển Đổi Đơn Vị
    public function unitConversionGame()
    {
        $questions = [
            [
                'value'    => 2000,
                'fromUnit' => 'm',
                'toUnit'   => 'km',
                'options'  => [1, 2, 3, 4]
            ],
            [
                'value'    => 3.5,
                'fromUnit' => 'kg',
                'toUnit'   => 'g',
                'options'  => [3500, 350, 35, 3050]
            ],
            [
                'value'    => 4500,
                'fromUnit' => 'ml',
                'toUnit'   => 'l',
                'options'  => [4.5, 45, 0.45, 450]
            ],
            [
                'value'    => 7.2,
                'fromUnit' => 'km',
                'toUnit'   => 'm',
                'options'  => [720, 7200, 72, 7020]
            ],
            [
                'value'    => 2500,
                'fromUnit' => 'g',
                'toUnit'   => 'kg',
                'options'  => [2.5, 25, 0.25, 250]
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.chuyen_doi_don_vi', ['questions' => $questions]);
    }

    // 4. Bảng Quy Đổi
    public function conversionTableGame()
    {
        $questions = [
            [
                'type'        => 'length',
                'values'      => [
                    ['value' => 2, 'unit' => 'km'],
                    ['value' => 3500, 'unit' => 'm'],
                    ['value' => 4200, 'unit' => 'm'],
                    ['value' => 1.8, 'unit' => 'km']
                ],
                'target_unit' => 'm'
            ],
            [
                'type'        => 'weight',
                'values'      => [
                    ['value' => 1.5, 'unit' => 'kg'],
                    ['value' => 2800, 'unit' => 'g'],
                    ['value' => 3.2, 'unit' => 'kg'],
                    ['value' => 1600, 'unit' => 'g']
                ],
                'target_unit' => 'g'
            ],
            [
                'type'        => 'volume',
                'values'      => [
                    ['value' => 2.5, 'unit' => 'l'],
                    ['value' => 1800, 'unit' => 'ml'],
                    ['value' => 3400, 'unit' => 'ml'],
                    ['value' => 4.2, 'unit' => 'l']
                ],
                'target_unit' => 'ml'
            ],
            [
                'type'        => 'mixed',
                'values'      => [
                    ['value' => 1.2, 'unit' => 'km'],
                    ['value' => 2.5, 'unit' => 'kg'],
                    ['value' => 3000, 'unit' => 'ml'],
                    ['value' => 4500, 'unit' => 'm']
                ],
                'conversions' => [
                    'km' => ['to' => 'm', 'multiplier' => 1000],
                    'kg' => ['to' => 'g', 'multiplier' => 1000],
                    'l'  => ['to' => 'ml', 'multiplier' => 1000]
                ]
            ],
            [
                'type'        => 'mixed',
                'values'      => [
                    ['value' => 2800, 'unit' => 'g'],
                    ['value' => 3.6, 'unit' => 'km'],
                    ['value' => 4.2, 'unit' => 'l'],
                    ['value' => 5500, 'unit' => 'm']
                ],
                'conversions' => [
                    'g'  => ['to' => 'kg', 'multiplier' => 0.001],
                    'm'  => ['to' => 'km', 'multiplier' => 0.001],
                    'ml' => ['to' => 'l', 'multiplier' => 0.001]
                ]
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.conversion_table', ['questions' => $questions]);
    }

    // 5. So Sánh Khoảng Cách
    public function distanceComparisonGame()
    {
        $questions = [
            [
                'distances' => [
                    ['value' => 1.5, 'unit' => 'km'],
                    ['value' => 1200, 'unit' => 'm'],
                    ['value' => 1800, 'unit' => 'm']
                ]
            ],
            [
                'distances' => [
                    ['value' => 2.5, 'unit' => 'km'],
                    ['value' => 2800, 'unit' => 'm'],
                    ['value' => 2300, 'unit' => 'm']
                ]
            ],
            [
                'distances' => [
                    ['value' => 3000, 'unit' => 'm'],
                    ['value' => 3.2, 'unit' => 'km'],
                    ['value' => 2900, 'unit' => 'm']
                ]
            ],
            [
                'distances' => [
                    ['value' => 4.5, 'unit' => 'km'],
                    ['value' => 4800, 'unit' => 'm'],
                    ['value' => 4600, 'unit' => 'm']
                ]
            ],
            [
                'distances' => [
                    ['value' => 5200, 'unit' => 'm'],
                    ['value' => 5.1, 'unit' => 'km'],
                    ['value' => 5300, 'unit' => 'm']
                ]
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.distance-comparison', ['questions' => $questions]);
    }

    // 6. Đo Độ Dài
    public function lengthMeasurementGame()
    {
        $questions = $this->getLengthQuestions();
        return view('games.lop4.thu_thach_do_luong.length_measurement', ['questions' => $questions]);
    }

    private function getLengthQuestions(): array
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
        $questions  = [];
        $preset     = [
            // 5 câu hỏi mẫu, mỗi câu 2-3 object, trộn đơn vị
            [0, 2, 3], // bút chì, thước kẻ, dây nhảy
            [1, 4],    // quyển vở, điện thoại
            [5, 6, 8], // hộp bút, chai nước, tờ giấy A4
            [7, 9],    // bàn học, cửa lớp học
            [2, 5, 1], // thước kẻ, hộp bút, quyển vở
        ];
        foreach ($preset as $idxs) {
            $objects = [];
            foreach ($idxs as $i) {
                $o              = $allObjects[$i];
                $o['length_cm'] = $o['unit'] === 'm' ? $o['length'] * 100 : $o['length'];
                $objects[]      = $o;
            }
            $type         = rand(0, 1) ? 'max' : 'min';
            $answer_index = 0;
            if ($type === 'max') {
                $max = max(array_column($objects, 'length_cm'));
                foreach ($objects as $i => $o) {
                    if ($o['length_cm'] == $max) {
                        $answer_index = $i;
                    }
                }
            } else {
                $min = min(array_column($objects, 'length_cm'));
                foreach ($objects as $i => $o) {
                    if ($o['length_cm'] == $min) {
                        $answer_index = $i;
                    }
                }
            }
            $questions[] = [
                'objects'      => $objects,
                'type'         => $type,
                'answer_index' => $answer_index
            ];
        }
        return $questions;
    }

    // 7. Bấm Giờ Chính Xác
    public function precisionTimingGame()
    {
        $questions = [
            [
                'target'       => 10,
                'allowedError' => 0.5,
                'description'  => 'Bấm giờ đúng 10 giây'
            ],
            [
                'target'       => 20,
                'allowedError' => 0.5,
                'description'  => 'Bấm giờ đúng 20 giây'
            ],
            [
                'target'       => 30,
                'allowedError' => 0.7,
                'description'  => 'Bấm giờ đúng 30 giây'
            ],
            [
                'target'       => 45,
                'allowedError' => 1,
                'description'  => 'Bấm giờ đúng 45 giây'
            ],
            [
                'target'       => 60,
                'allowedError' => 1,
                'description'  => 'Bấm giờ đúng 1 phút'
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.precision_timing', ['questions' => $questions]);
    }

    // 8. Thời Gian Phiêu Lưu (refactor: trả về danh sách nhiều câu hỏi cho client xử lý)
    public function timeAdventureGame()
    {
        $questions = [
            [
                'startTime' => '08:30',
                'duration'  => 45,
                'type'      => 'minutes',
                'endTime'   => '09:15',
                'options'   => ['09:00', '09:15', '09:45', '08:45']
            ],
            [
                'startTime' => '10:15',
                'duration'  => 2,
                'type'      => 'hours',
                'endTime'   => '12:15',
                'options'   => ['12:15', '11:45', '13:15', '10:45']
            ],
            [
                'startTime' => '14:20',
                'duration'  => 90,
                'type'      => 'minutes',
                'endTime'   => '15:50',
                'options'   => ['15:20', '15:50', '16:00', '14:50']
            ],
            [
                'startTime' => '09:45',
                'duration'  => 3.5,
                'type'      => 'hours',
                'endTime'   => '13:15',
                'options'   => ['13:15', '12:45', '14:15', '10:15']
            ],
            [
                'startTime' => '16:30',
                'duration'  => 150,
                'type'      => 'minutes',
                'endTime'   => '19:00',
                'options'   => ['18:30', '19:00', '17:00', '19:30']
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.thoi_gian_phieu_luu', ['questions' => $questions]);
    }

    // 9. So Sánh Thời Gian
    public function timeComparisonGame()
    {
        $questions = [
            [
                'times' => [
                    ['hours' => 1, 'minutes' => 30],
                    ['hours' => 2, 'minutes' => 0],
                    ['hours' => 1, 'minutes' => 45]
                ]
            ],
            [
                'times' => [
                    ['hours' => 2, 'minutes' => 15],
                    ['hours' => 2, 'minutes' => 45],
                    ['hours' => 2, 'minutes' => 30]
                ]
            ],
            [
                'times' => [
                    ['hours' => 3, 'minutes' => 0],
                    ['hours' => 2, 'minutes' => 55],
                    ['hours' => 3, 'minutes' => 5]
                ]
            ],
            [
                'times' => [
                    ['hours' => 4, 'minutes' => 30],
                    ['hours' => 4, 'minutes' => 15],
                    ['hours' => 4, 'minutes' => 45]
                ]
            ],
            [
                'times' => [
                    ['hours' => 5, 'minutes' => 25],
                    ['hours' => 5, 'minutes' => 30],
                    ['hours' => 5, 'minutes' => 15]
                ]
            ]
        ];
        return view('games.lop4.thu_thach_do_luong.time_comparison', ['questions' => $questions]);
    }

    // 10. Ước Lượng Khối Lượng
    public function weightEstimationGame()
    {
        $questions = $this->generateCompareWeightQuestions();
        return view('games.lop4.thu_thach_do_luong.weight_estimation', ['questions' => $questions]);
    }

    private function generateCompareWeightQuestions(): array
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
        $questions  = [];
        for ($i = 0; $i < 5; $i++) {
            $objects = $allObjects;
            shuffle($objects);
            $num     = rand(2, 3);
            $objects = array_slice($objects, 0, $num);
            foreach ($objects as &$o) {
                if ($o['unit'] === 'kg') {
                    $o['weight_g'] = $o['weight'] * 1000;
                } else {
                    $o['weight_g'] = $o['weight'];
                }
            }
            unset($o);
            $type         = rand(0, 1) ? 'max' : 'min';
            $answer_index = 0;
            if ($type === 'max') {
                $max = max(array_column($objects, 'weight_g'));
                foreach ($objects as $j => $o) {
                    if ($o['weight_g'] == $max) {
                        $answer_index = $j;
                    }
                }
            } else {
                $min = min(array_column($objects, 'weight_g'));
                foreach ($objects as $j => $o) {
                    if ($o['weight_g'] == $min) {
                        $answer_index = $j;
                    }
                }
            }
            $questions[] = [
                'objects'      => array_map(function ($o) {
                    unset($o['weight_g']);
                    return $o;
                }, $objects),
                'type'         => $type,
                'answer_index' => $answer_index
            ];
        }
        return $questions;
    }

    // 11. Sắp Xếp Khối Lượng
    public function weightSortingGame()
    {
        $questions = $this->generateWeightSortingQuestions();
        return view('games.lop4.thu_thach_do_luong.weight_sorting', ['questions' => $questions]);
    }

    private function generateWeightSortingQuestions(): array
    {
        return [
            [
                'weights' => [
                    ['value' => 500, 'unit' => 'g'],
                    ['value' => 0.7, 'unit' => 'kg'],
                    ['value' => 300, 'unit' => 'g'],
                    ['value' => 0.9, 'unit' => 'kg']
                ]
            ],
            [
                'weights' => [
                    ['value' => 1.2, 'unit' => 'kg'],
                    ['value' => 900, 'unit' => 'g'],
                    ['value' => 1500, 'unit' => 'g'],
                    ['value' => 0.8, 'unit' => 'kg']
                ]
            ],
            [
                'weights' => [
                    ['value' => 2000, 'unit' => 'g'],
                    ['value' => 1.5, 'unit' => 'kg'],
                    ['value' => 2.5, 'unit' => 'kg'],
                    ['value' => 1800, 'unit' => 'g']
                ]
            ],
            [
                'weights' => [
                    ['value' => 3.2, 'unit' => 'kg'],
                    ['value' => 2800, 'unit' => 'g'],
                    ['value' => 3500, 'unit' => 'g'],
                    ['value' => 2.9, 'unit' => 'kg']
                ]
            ],
            [
                'weights' => [
                    ['value' => 4500, 'unit' => 'g'],
                    ['value' => 5, 'unit' => 'kg'],
                    ['value' => 4.2, 'unit' => 'kg'],
                    ['value' => 3800, 'unit' => 'g']
                ]
            ]
        ];
    }
}
