<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiaiToanLoiVanController extends Controller
{
    public function index()
    {
        return view('games.lop4.giai_toan_loi_van.giai_toan_loi_van');
    }

    public function lostCity()
    {
        $question = $this->generateLostCityQuestion();
        session(['current_lost_city_question' => $question]);
        
        return view('games.lop4.giai_toan_loi_van.lost_city', [
            'title' => 'Thành Phố Bí Ẩn',
            'question' => $question
        ]);
    }

    private function generateLostCityQuestion()
    {
        $level = session('lost_city_level', 1);
        
        $questions = [
            1 => [
                'level' => 1,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một cửa hàng có 120 quyển sách. Ngày thứ nhất bán được 40 quyển. Hỏi còn lại bao nhiêu quyển sách?',
                        'answer' => 80,
                        'hint' => 'Số sách còn lại = 120 - 40 = 80 quyển'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một đội công nhân làm trong 3 ngày. Ngày thứ nhất làm được 25% công việc. Hỏi còn lại bao nhiêu phần trăm công việc?',
                        'answer' => 75,
                        'hint' => 'Công việc còn lại = 100% - 25% = 75%'
                    ]
                ]
            ],
            2 => [
                'level' => 2,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một mảnh vườn hình chữ nhật có chiều dài gấp 3 lần chiều rộng. Nếu tăng chiều rộng thêm 2m thì diện tích tăng thêm 24m². Tính chiều rộng ban đầu.',
                        'answer' => 4,
                        'hint' => 'Gọi chiều rộng là x, chiều dài là 3x. Diện tích tăng: 3x × 2 = 24 → x = 4'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Tổng số tuổi của hai anh em là 24 tuổi. Biết tuổi em bằng 2/3 tuổi anh. Hỏi tuổi em là bao nhiêu?',
                        'answer' => 10,
                        'hint' => 'Gọi tuổi em là x, tuổi anh là y. Ta có: x + y = 24 và x = (2/3)y. Thay x = (2/3)y vào phương trình đầu: (2/3)y + y = 24 → (5/3)y = 24 → y = 14.4 → x = 10'
                    ]
                ]
            ],
            3 => [
                'level' => 3,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một bể nước có 3 vòi. Vòi 1 chảy đầy bể trong 6 giờ, vòi 2 chảy đầy bể trong 8 giờ, vòi 3 chảy đầy bể trong 12 giờ. Nếu mở cả 3 vòi cùng lúc thì sau bao nhiêu giờ bể sẽ đầy?',
                        'answer' => 3,
                        'hint' => 'Trong 1 giờ: Vòi 1 chảy 1/6 bể, vòi 2 chảy 1/8 bể, vòi 3 chảy 1/12 bể. Cả 3 vòi chảy: 1/6 + 1/8 + 1/12 = 3/8 bể. Thời gian đầy bể: 1 ÷ 3/8 = 8/3 giờ'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một người đi từ A đến B với vận tốc 40km/h. Khi về từ B đến A, người đó đi với vận tốc 60km/h. Tổng thời gian đi và về là 5 giờ. Tính quãng đường AB.',
                        'answer' => 120,
                        'hint' => 'Gọi quãng đường là x. Thời gian đi: x/40. Thời gian về: x/60. Tổng thời gian: x/40 + x/60 = 5. Giải phương trình: x = 120km'
                    ]
                ]
            ],
            4 => [
                'level' => 4,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một cửa hàng có 120 quyển sách. Ngày thứ nhất bán được 40 quyển, ngày thứ hai bán được 20 quyển. Hỏi cửa hàng còn lại bao nhiêu quyển sách?',
                        'answer' => 60,
                        'hint' => 'Ngày 1 bán: 40 quyển. Còn lại: 120 - 40 = 80 quyển. Ngày 2 bán: 20 quyển. Còn lại: 80 - 20 = 60 quyển'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một đội công nhân làm trong 3 ngày. Ngày thứ nhất làm được 25% công việc, ngày thứ hai làm được 25% công việc còn lại. Hỏi ngày thứ ba phải làm bao nhiêu phần trăm công việc?',
                        'answer' => 50,
                        'hint' => 'Ngày 1 làm: 25% công việc. Còn lại: 100% - 25% = 75% công việc. Ngày 2 làm: 75% × 25% = 25% công việc. Ngày 3 làm: 100% - 25% - 25% = 50% công việc'
                    ]
                ]
            ],
            5 => [
                'level' => 5,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một bể nước có 3 vòi. Vòi 1 chảy đầy bể trong 6 giờ, vòi 2 chảy đầy bể trong 8 giờ, vòi 3 chảy đầy bể trong 12 giờ. Nếu mở cả 3 vòi cùng lúc thì sau bao nhiêu giờ bể sẽ đầy?',
                        'answer' => 3,
                        'hint' => 'Trong 1 giờ: Vòi 1 chảy 1/6 bể, vòi 2 chảy 1/8 bể, vòi 3 chảy 1/12 bể. Cả 3 vòi chảy: 1/6 + 1/8 + 1/12 = 9/24 = 3/8 bể. Thời gian đầy bể: 1 ÷ 3/8 = 8/3 giờ'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một người đi từ A đến B với vận tốc 40km/h. Khi về từ B đến A, người đó đi với vận tốc 60km/h. Tổng thời gian đi và về là 5 giờ. Tính quãng đường AB.',
                        'answer' => 120,
                        'hint' => 'Gọi quãng đường là x. Thời gian đi: x/40. Thời gian về: x/60. Tổng thời gian: x/40 + x/60 = 5. Giải phương trình: x = 120km'
                    ]
                ]
            ],
            6 => [
                'level' => 6,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một cửa hàng có 150 quyển sách. Ngày thứ nhất bán được 30% số sách, ngày thứ hai bán được 40% số sách còn lại. Hỏi cửa hàng còn lại bao nhiêu quyển sách?',
                        'answer' => 63,
                        'hint' => 'Ngày 1 bán: 150 × 30% = 45 quyển. Còn lại: 150 - 45 = 105 quyển. Ngày 2 bán: 105 × 40% = 42 quyển. Còn lại: 105 - 42 = 63 quyển'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một đội công nhân làm trong 4 ngày. Ngày thứ nhất làm được 20% công việc, ngày thứ hai làm được 30% công việc còn lại, ngày thứ ba làm được 25% công việc còn lại. Hỏi ngày thứ tư phải làm bao nhiêu phần trăm công việc?',
                        'answer' => 42,
                        'hint' => 'Ngày 1 làm: 20%. Còn lại: 80%. Ngày 2 làm: 80% × 30% = 24%. Còn lại: 56%. Ngày 3 làm: 56% × 25% = 14%. Còn lại: 42%'
                    ]
                ]
            ],
            7 => [
                'level' => 7,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một mảnh vườn hình chữ nhật có chiều dài gấp 4 lần chiều rộng. Nếu tăng chiều rộng thêm 3m và giảm chiều dài đi 2m thì diện tích tăng thêm 36m². Tính chiều rộng ban đầu.',
                        'answer' => 5,
                        'hint' => 'Gọi chiều rộng là x, chiều dài là 4x. Diện tích ban đầu: 4x². Diện tích mới: (4x-2)(x+3) = 4x² + 10x - 6. Tăng thêm: 10x - 6 = 36 → x = 5'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Tổng số tuổi của ba anh em là 36 tuổi. Biết tuổi em út bằng 1/2 tuổi anh hai, tuổi anh hai bằng 2/3 tuổi anh cả. Hỏi tuổi em út là bao nhiêu?',
                        'answer' => 6,
                        'hint' => 'Gọi tuổi em út là x, tuổi anh hai là 2x, tuổi anh cả là 3x. Tổng: x + 2x + 3x = 6x = 36 → x = 6'
                    ]
                ]
            ],
            8 => [
                'level' => 8,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một bể nước có 4 vòi. Vòi 1 chảy đầy bể trong 6 giờ, vòi 2 chảy đầy bể trong 8 giờ, vòi 3 chảy đầy bể trong 12 giờ, vòi 4 chảy đầy bể trong 24 giờ. Nếu mở cả 4 vòi cùng lúc thì sau bao nhiêu giờ bể sẽ đầy?',
                        'answer' => 2,
                        'hint' => 'Trong 1 giờ: Vòi 1 chảy 1/6 bể, vòi 2 chảy 1/8 bể, vòi 3 chảy 1/12 bể, vòi 4 chảy 1/24 bể. Cả 4 vòi chảy: 1/6 + 1/8 + 1/12 + 1/24 = 1/2 bể. Thời gian đầy bể: 1 ÷ 1/2 = 2 giờ'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một người đi từ A đến B với vận tốc 40km/h. Khi về từ B đến A, người đó đi với vận tốc 60km/h. Tổng thời gian đi và về là 5 giờ. Tính quãng đường AB.',
                        'answer' => 120,
                        'hint' => 'Gọi quãng đường là x. Thời gian đi: x/40. Thời gian về: x/60. Tổng thời gian: x/40 + x/60 = 5. Giải phương trình: x = 120km'
                    ]
                ]
            ],
            9 => [
                'level' => 9,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một cửa hàng có 200 quyển sách. Ngày thứ nhất bán được 25% số sách, ngày thứ hai bán được 30% số sách còn lại, ngày thứ ba bán được 20% số sách còn lại. Hỏi cửa hàng còn lại bao nhiêu quyển sách?',
                        'answer' => 84,
                        'hint' => 'Ngày 1 bán: 200 × 25% = 50 quyển. Còn lại: 150 quyển. Ngày 2 bán: 150 × 30% = 45 quyển. Còn lại: 105 quyển. Ngày 3 bán: 105 × 20% = 21 quyển. Còn lại: 84 quyển'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Một đội công nhân làm trong 5 ngày. Ngày thứ nhất làm được 15% công việc, ngày thứ hai làm được 20% công việc còn lại, ngày thứ ba làm được 25% công việc còn lại, ngày thứ tư làm được 30% công việc còn lại. Hỏi ngày thứ năm phải làm bao nhiêu phần trăm công việc?',
                        'answer' => 36,
                        'hint' => 'Ngày 1 làm: 15%. Còn lại: 85%. Ngày 2 làm: 85% × 20% = 17%. Còn lại: 68%. Ngày 3 làm: 68% × 25% = 17%. Còn lại: 51%. Ngày 4 làm: 51% × 30% = 15%. Còn lại: 36%'
                    ]
                ]
            ],
            10 => [
                'level' => 10,
                'streets' => [
                    [
                        'id' => 1,
                        'name' => 'Đường Số 1',
                        'description' => 'Một mảnh vườn hình chữ nhật có chiều dài gấp 5 lần chiều rộng. Nếu tăng chiều rộng thêm 4m và giảm chiều dài đi 3m thì diện tích tăng thêm 48m². Tính chiều rộng ban đầu.',
                        'answer' => 6,
                        'hint' => 'Gọi chiều rộng là x, chiều dài là 5x. Diện tích ban đầu: 5x². Diện tích mới: (5x-3)(x+4) = 5x² + 17x - 12. Tăng thêm: 17x - 12 = 48 → x = 6'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đường Số 2',
                        'description' => 'Tổng số tuổi của bốn anh em là 48 tuổi. Biết tuổi em út bằng 1/3 tuổi anh ba, tuổi anh ba bằng 2/3 tuổi anh hai, tuổi anh hai bằng 3/4 tuổi anh cả. Hỏi tuổi em út là bao nhiêu?',
                        'answer' => 4,
                        'hint' => 'Gọi tuổi em út là x, tuổi anh ba là 3x, tuổi anh hai là 4.5x, tuổi anh cả là 6x. Tổng: x + 3x + 4.5x + 6x = 14.5x = 48 → x = 4'
                    ]
                ]
            ]
        ];

        // Lấy ngẫu nhiên một câu hỏi từ cấp độ hiện tại
        $levelQuestions = $questions[$level];
        $randomStreet = $levelQuestions['streets'][array_rand($levelQuestions['streets'])];
        
        return [
            'level' => $level,
            'streets' => [$randomStreet]
        ];
    }

    public function checkLostCityAnswer(Request $request)
    {
        $answers = $request->input('answers');
        $currentLevel = session('lost_city_level', 1);
        $currentQuestion = session('current_lost_city_question');
        
        if (!$currentQuestion) {
            return response()->json([
                'correct' => false,
                'next_level' => false,
                'message' => 'Không tìm thấy câu hỏi hiện tại'
            ]);
        }

        $correct = true;
        $wrongAnswers = [];
        foreach ($currentQuestion['streets'] as $street) {
            if (!isset($answers[$street['id'] - 1]) || (int)$answers[$street['id'] - 1] !== (int)$street['answer']) {
                $correct = false;
                $wrongAnswers[] = [
                    'street' => $street['name'],
                    'hint' => $street['hint']
                ];
            }
        }

        if ($correct) {
            if ($currentLevel < 10) {
                session(['lost_city_level' => $currentLevel + 1]);
            }
        }

        return response()->json([
            'correct' => $correct,
            'next_level' => $correct && $currentLevel < 10,
            'wrong_answers' => $wrongAnswers
        ]);
    }

    public function resetLostCity()
    {
        session(['lost_city_level' => 1]);
        return redirect()->route('games.lop4.giai_toan_loi_van.lost_city');
    }

    private function generateQuestion($level)
    {
        $questions = [
            // Cấp độ 1: Bài toán đơn giản về cộng trừ
            1 => [
                [
                    'question' => 'Mẹ mua 5 quả cam và 3 quả táo. Hỏi mẹ mua tất cả bao nhiêu quả?',
                    'options' => ['7 quả', '8 quả', '9 quả', '10 quả'],
                    'answer' => '8 quả',
                    'explanation' => 'Số quả mẹ mua = 5 + 3 = 8 quả'
                ],
                [
                    'question' => 'Lớp 4A có 32 học sinh, trong đó có 15 học sinh nam. Hỏi lớp 4A có bao nhiêu học sinh nữ?',
                    'options' => ['15 học sinh', '17 học sinh', '19 học sinh', '21 học sinh'],
                    'answer' => '17 học sinh',
                    'explanation' => 'Số học sinh nữ = 32 - 15 = 17 học sinh'
                ]
            ],
            // Cấp độ 2: Bài toán về nhân chia đơn giản
            2 => [
                [
                    'question' => 'Mỗi hộp có 6 viên kẹo. Hỏi 8 hộp như thế có bao nhiêu viên kẹo?',
                    'options' => ['42 viên', '44 viên', '46 viên', '48 viên'],
                    'answer' => '48 viên',
                    'explanation' => 'Số viên kẹo = 6 × 8 = 48 viên'
                ],
                [
                    'question' => 'Có 45 quyển vở chia đều cho 9 bạn. Hỏi mỗi bạn được bao nhiêu quyển vở?',
                    'options' => ['4 quyển', '5 quyển', '6 quyển', '7 quyển'],
                    'answer' => '5 quyển',
                    'explanation' => 'Số vở mỗi bạn = 45 ÷ 9 = 5 quyển'
                ]
            ],
            // Cấp độ 3: Bài toán kết hợp các phép tính
            3 => [
                [
                    'question' => 'Một cửa hàng có 120 quyển sách. Ngày thứ nhất bán được 1/3 số sách, ngày thứ hai bán được 1/4 số sách còn lại. Hỏi cửa hàng còn lại bao nhiêu quyển sách?',
                    'options' => ['60 quyển', '65 quyển', '70 quyển', '75 quyển'],
                    'answer' => '60 quyển',
                    'explanation' => 'Ngày 1 bán: 120 ÷ 3 = 40 quyển. Còn lại: 120 - 40 = 80 quyển. Ngày 2 bán: 80 ÷ 4 = 20 quyển. Còn lại: 80 - 20 = 60 quyển'
                ],
                [
                    'question' => 'Một đội công nhân làm trong 3 ngày. Ngày thứ nhất làm được 1/4 công việc, ngày thứ hai làm được 1/3 công việc còn lại. Hỏi ngày thứ ba phải làm bao nhiêu phần công việc?',
                    'options' => ['1/2 công việc', '1/3 công việc', '1/4 công việc', '1/6 công việc'],
                    'answer' => '1/2 công việc',
                    'explanation' => 'Ngày 1 làm: 1/4 công việc. Còn lại: 1 - 1/4 = 3/4 công việc. Ngày 2 làm: 3/4 × 1/3 = 1/4 công việc. Ngày 3 làm: 1 - 1/4 - 1/4 = 1/2 công việc'
                ]
            ],
            // Cấp độ 4: Bài toán về tỉ số và tỉ lệ
            4 => [
                [
                    'question' => 'Tổng số tuổi của hai anh em là 24 tuổi. Biết tuổi em bằng 2/3 tuổi anh. Hỏi anh bao nhiêu tuổi?',
                    'options' => ['12 tuổi', '14 tuổi', '16 tuổi', '18 tuổi'],
                    'answer' => '14 tuổi',
                    'explanation' => 'Tổng số phần: 2 + 3 = 5 phần. Tuổi anh: 24 ÷ 5 × 3 = 14 tuổi'
                ],
                [
                    'question' => 'Một mảnh vườn hình chữ nhật có chiều dài gấp 3 lần chiều rộng. Nếu tăng chiều rộng thêm 2m thì diện tích tăng thêm 24m². Tính diện tích mảnh vườn ban đầu.',
                    'options' => ['48m²', '54m²', '60m²', '72m²'],
                    'answer' => '48m²',
                    'explanation' => 'Gọi chiều rộng là x, chiều dài là 3x. Diện tích ban đầu: 3x². Diện tích mới: 3x(x+2) = 3x² + 6x. Tăng thêm: 6x = 24 → x = 4. Diện tích ban đầu: 3 × 4² = 48m²'
                ]
            ],
            // Cấp độ 5: Bài toán phức tạp
            5 => [
                [
                    'question' => 'Một bể nước có 3 vòi. Vòi 1 chảy đầy bể trong 6 giờ, vòi 2 chảy đầy bể trong 8 giờ, vòi 3 chảy đầy bể trong 12 giờ. Nếu mở cả 3 vòi cùng lúc thì sau bao lâu bể sẽ đầy?',
                    'options' => ['2 giờ', '2 giờ 24 phút', '2 giờ 40 phút', '3 giờ'],
                    'answer' => '2 giờ 24 phút',
                    'explanation' => 'Trong 1 giờ: Vòi 1 chảy 1/6 bể, vòi 2 chảy 1/8 bể, vòi 3 chảy 1/12 bể. Cả 3 vòi chảy: 1/6 + 1/8 + 1/12 = 9/24 = 3/8 bể. Thời gian đầy bể: 1 ÷ 3/8 = 8/3 giờ = 2 giờ 24 phút'
                ],
                [
                    'question' => 'Một người đi từ A đến B với vận tốc 40km/h. Khi về từ B đến A, người đó đi với vận tốc 60km/h. Tổng thời gian đi và về là 5 giờ. Tính quãng đường AB.',
                    'options' => ['100km', '120km', '140km', '160km'],
                    'answer' => '120km',
                    'explanation' => 'Gọi quãng đường là x. Thời gian đi: x/40. Thời gian về: x/60. Tổng thời gian: x/40 + x/60 = 5. Giải phương trình: x = 120km'
                ]
            ]
        ];

        // Lấy ngẫu nhiên một câu hỏi từ cấp độ hiện tại
        $levelQuestions = $questions[$level];
        $randomQuestion = $levelQuestions[array_rand($levelQuestions)];
        
        return [
            'level' => $level,
            'question' => $randomQuestion['question'],
            'options' => $randomQuestion['options'],
            'answer' => $randomQuestion['answer'],
            'explanation' => $randomQuestion['explanation']
        ];
    }

    public function wordProblemGame(Request $request)
    {
        // Lấy cấp độ từ session hoặc mặc định là 1
        $level = session('word_problem_level', 1);
        
        // Tạo câu hỏi cho cấp độ hiện tại
        $question = $this->generateQuestion($level);

        return view('games.lop4.giai_toan_loi_van.word_problem', compact('question'));
    }

    public function checkAnswer(Request $request)
    {
        $answer = $request->input('answer');
        $correctAnswer = $request->input('correct_answer');
        $currentLevel = session('word_problem_level', 1);

        $isCorrect = $answer === $correctAnswer;

        if ($isCorrect) {
            // Tăng cấp độ nếu chưa đạt cấp độ tối đa
            if ($currentLevel < 5) {
                session(['word_problem_level' => $currentLevel + 1]);
            }
        }

        return response()->json([
            'correct' => $isCorrect,
            'next_level' => $isCorrect && $currentLevel < 5
        ]);
    }

    public function resetGame()
    {
        session(['word_problem_level' => 1]);
        return redirect()->route('games.lop4.giai_toan_loi_van.word_problem');
    }
} 