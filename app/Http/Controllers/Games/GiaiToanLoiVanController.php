<?php

namespace App\Http\Controllers\Games;

class GiaiToanLoiVanController extends AbstractGroupGameController
{
    protected string $group = 'giai_toan_loi_van';

    public function lostCity()
    {
        $questions = $this->generateRandomLostCityQuestions();

        return view('games.lop4.giai_toan_loi_van.lost_city', [
            'title'     => 'Thành Phố Bí Ẩn',
            'questions' => $questions
        ]);
    }

    private function generateRandomLostCityQuestions(): array
    {
        $allQuestions = [
            1  => [
                'name'        => 'Đường Số 1',
                'description' => 'Một cửa hàng có 120 quyển sách. Ngày thứ nhất bán được 40 quyển. Hỏi còn lại bao nhiêu quyển sách?',
                'answer'      => 80,
                'hint'        => 'Số sách còn lại = 120 - 40 = 80 quyển'
            ],
            2  => [
                'name'        => 'Đường Số 2',
                'description' => 'Một đội công nhân làm trong 3 ngày. Ngày thứ nhất làm được 25% công việc. Hỏi còn lại bao nhiêu phần trăm công việc?',
                'answer'      => 75,
                'hint'        => 'Công việc còn lại = 100% - 25% = 75%'
            ],
            3  => [
                'name'        => 'Đường Số 3',
                'description' => 'Một mảnh vườn hình chữ nhật có chiều dài gấp 3 lần chiều rộng. Nếu tăng chiều rộng thêm 2m thì diện tích tăng thêm 24m². Tính chiều rộng ban đầu.',
                'answer'      => 4,
                'hint'        => 'Gọi chiều rộng là x, chiều dài là 3x. Diện tích tăng: 3x × 2 = 24 → x = 4'
            ],
            4  => [
                'name'        => 'Đường Số 4',
                'description' => 'Tổng số tuổi của hai anh em là 24 tuổi. Biết tuổi em bằng 2/3 tuổi anh. Hỏi tuổi em là bao nhiêu?',
                'answer'      => 10,
                'hint'        => 'Gọi tuổi em là x, tuổi anh là y. Ta có: x + y = 24 và x = (2/3)y. Thay x = (2/3)y vào phương trình đầu: (2/3)y + y = 24 → (5/3)y = 24 → y = 14.4 → x = 10'
            ],
            5  => [
                'name'        => 'Đường Số 5',
                'description' => 'Một bể nước có 3 vòi. Vòi 1 chảy đầy bể trong 6 giờ, vòi 2 chảy đầy bể trong 8 giờ, vòi 3 chảy đầy bể trong 12 giờ. Nếu mở cả 3 vòi cùng lúc thì sau bao nhiêu giờ bể sẽ đầy?',
                'answer'      => 3,
                'hint'        => 'Trong 1 giờ: Vòi 1 chảy 1/6 bể, vòi 2 chảy 1/8 bể, vòi 3 chảy 1/12 bể. Cả 3 vòi chảy: 1/6 + 1/8 + 1/12 = 3/8 bể. Thời gian đầy bể: 1 ÷ 3/8 = 8/3 giờ'
            ],
            6  => [
                'name'        => 'Đường Số 6',
                'description' => 'Một người đi từ A đến B với vận tốc 40km/h. Khi về từ B đến A, người đó đi với vận tốc 60km/h. Tổng thời gian đi và về là 5 giờ. Tính quãng đường AB.',
                'answer'      => 120,
                'hint'        => 'Gọi quãng đường là x. Thời gian đi: x/40. Thời gian về: x/60. Tổng thời gian: x/40 + x/60 = 5. Giải phương trình: x = 120km'
            ],
            7  => [
                'name'        => 'Đường Số 7',
                'description' => 'Một cửa hàng có 150 quyển sách. Ngày thứ nhất bán được 30% số sách, ngày thứ hai bán được 40% số sách còn lại. Hỏi cửa hàng còn lại bao nhiêu quyển sách?',
                'answer'      => 63,
                'hint'        => 'Ngày 1 bán: 150 × 30% = 45 quyển. Còn lại: 150 - 45 = 105 quyển. Ngày 2 bán: 105 × 40% = 42 quyển. Còn lại: 105 - 42 = 63 quyển'
            ],
            8  => [
                'name'        => 'Đường Số 8',
                'description' => 'Một đội công nhân làm trong 4 ngày. Ngày thứ nhất làm được 20% công việc, ngày thứ hai làm được 30% công việc còn lại, ngày thứ ba làm được 25% công việc còn lại. Hỏi ngày thứ tư phải làm bao nhiêu phần trăm công việc?',
                'answer'      => 42,
                'hint'        => 'Ngày 1 làm: 20%. Còn lại: 80%. Ngày 2 làm: 80% × 30% = 24%. Còn lại: 56%. Ngày 3 làm: 56% × 25% = 14%. Còn lại: 42%'
            ],
            9  => [
                'name'        => 'Đường Số 9',
                'description' => 'Một mảnh vườn hình chữ nhật có chiều dài gấp 4 lần chiều rộng. Nếu tăng chiều rộng thêm 3m và giảm chiều dài đi 2m thì diện tích tăng thêm 36m². Tính chiều rộng ban đầu.',
                'answer'      => 5,
                'hint'        => 'Gọi chiều rộng là x, chiều dài là 4x. Diện tích ban đầu: 4x². Diện tích mới: (4x-2)(x+3) = 4x² + 10x - 6. Tăng thêm: 10x - 6 = 36 → x = 5'
            ],
            10 => [
                'name'        => 'Đường Số 10',
                'description' => 'Tổng số tuổi của ba anh em là 36 tuổi. Biết tuổi em út bằng 1/2 tuổi anh hai, tuổi anh hai bằng 2/3 tuổi anh cả. Hỏi tuổi em út là bao nhiêu?',
                'answer'      => 6,
                'hint'        => 'Gọi tuổi em út là x, tuổi anh hai là 2x, tuổi anh cả là 3x. Tổng: x + 2x + 3x = 6x = 36 → x = 6'
            ]
        ];

        // Chọn ngẫu nhiên 5 câu hỏi
        $randomKeys        = array_rand($allQuestions, 5);
        $selectedQuestions = [];

        foreach ($randomKeys as $index => $key) {
            $selectedQuestions[$index + 1] = $allQuestions[$key];
        }

        return $selectedQuestions;
    }

    public function wordProblemGame()
    {
        // Trả về tất cả dữ liệu câu hỏi cho frontend xử lý
        $allQuestions = $this->getAllQuestions();

        return view('games.lop4.giai_toan_loi_van.word_problem', [
            'allQuestions' => $allQuestions
        ]);
    }

    private function getAllQuestions(): array
    {
        return [
            1 => [
                [
                    'question'    => 'Một cửa hàng có 24 quả cam. Họ đã bán được 1/3 số cam. Hỏi còn lại bao nhiêu quả cam?',
                    'options'     => ['16 quả', '18 quả', '20 quả', '22 quả'],
                    'answer'      => '16 quả',
                    'explanation' => 'Số cam đã bán: 24 × 1/3 = 8 quả. Số cam còn lại: 24 - 8 = 16 quả.',
                    'level'       => 1
                ],
                [
                    'question'    => 'Một lớp học có 30 học sinh. 1/5 số học sinh vắng mặt. Hỏi có bao nhiêu học sinh đi học?',
                    'options'     => ['24 học sinh', '25 học sinh', '26 học sinh', '27 học sinh'],
                    'answer'      => '24 học sinh',
                    'explanation' => 'Số học sinh vắng: 30 × 1/5 = 6 học sinh. Số học sinh đi học: 30 - 6 = 24 học sinh.',
                    'level'       => 1
                ],
                [
                    'question'    => 'Một hộp có 36 viên kẹo. Em đã ăn 1/4 số kẹo. Hỏi còn lại bao nhiêu viên kẹo?',
                    'options'     => ['27 viên', '28 viên', '29 viên', '30 viên'],
                    'answer'      => '27 viên',
                    'explanation' => 'Số kẹo đã ăn: 36 × 1/4 = 9 viên. Số kẹo còn lại: 36 - 9 = 27 viên.',
                    'level'       => 1
                ]
            ],
            2 => [
                [
                    'question'    => 'Một bể nước chứa 120 lít nước. Người ta đã sử dụng 2/5 số nước. Hỏi còn lại bao nhiêu lít nước?',
                    'options'     => ['72 lít', '80 lít', '88 lít', '96 lít'],
                    'answer'      => '72 lít',
                    'explanation' => 'Số nước đã sử dụng: 120 × 2/5 = 48 lít. Số nước còn lại: 120 - 48 = 72 lít.',
                    'level'       => 2
                ],
                [
                    'question'    => 'Một thùng có 100 quả táo. 3/10 số táo bị hỏng. Hỏi còn lại bao nhiêu quả táo tốt?',
                    'options'     => ['60 quả', '70 quả', '80 quả', '90 quả'],
                    'answer'      => '70 quả',
                    'explanation' => 'Số táo hỏng: 100 × 3/10 = 30 quả. Số táo tốt: 100 - 30 = 70 quả.',
                    'level'       => 2
                ],
                [
                    'question'    => 'Một trường có 200 học sinh. 2/5 số học sinh là nam. Hỏi có bao nhiêu học sinh nữ?',
                    'options'     => ['100 học sinh', '110 học sinh', '120 học sinh', '130 học sinh'],
                    'answer'      => '120 học sinh',
                    'explanation' => 'Số học sinh nam: 200 × 2/5 = 80 học sinh. Số học sinh nữ: 200 - 80 = 120 học sinh.',
                    'level'       => 2
                ]
            ],
            3 => [
                [
                    'question'    => 'Một vườn cây có 150 cây. 3/5 số cây là cây ăn quả. Hỏi có bao nhiêu cây không phải cây ăn quả?',
                    'options'     => ['60 cây', '70 cây', '80 cây', '90 cây'],
                    'answer'      => '60 cây',
                    'explanation' => 'Số cây ăn quả: 150 × 3/5 = 90 cây. Số cây không phải cây ăn quả: 150 - 90 = 60 cây.',
                    'level'       => 3
                ],
                [
                    'question'    => 'Một cửa hàng có 180 sản phẩm. 4/9 số sản phẩm đã bán hết. Hỏi còn lại bao nhiêu sản phẩm?',
                    'options'     => ['100 sản phẩm', '110 sản phẩm', '120 sản phẩm', '130 sản phẩm'],
                    'answer'      => '100 sản phẩm',
                    'explanation' => 'Số sản phẩm đã bán: 180 × 4/9 = 80 sản phẩm. Số sản phẩm còn lại: 180 - 80 = 100 sản phẩm.',
                    'level'       => 3
                ],
                [
                    'question'    => 'Một đội có 240 công nhân. 5/8 số công nhân là nam. Hỏi có bao nhiêu công nhân nữ?',
                    'options'     => ['80 công nhân', '90 công nhân', '100 công nhân', '110 công nhân'],
                    'answer'      => '90 công nhân',
                    'explanation' => 'Số công nhân nam: 240 × 5/8 = 150 công nhân. Số công nhân nữ: 240 - 150 = 90 công nhân.',
                    'level'       => 3
                ]
            ],
            4 => [
                [
                    'question'    => 'Một công ty có 300 nhân viên. 7/12 số nhân viên là nam. Hỏi có bao nhiêu nhân viên nữ?',
                    'options'     => ['125 nhân viên', '130 nhân viên', '135 nhân viên', '140 nhân viên'],
                    'answer'      => '125 nhân viên',
                    'explanation' => 'Số nhân viên nam: 300 × 7/12 = 175 nhân viên. Số nhân viên nữ: 300 - 175 = 125 nhân viên.',
                    'level'       => 4
                ],
                [
                    'question'    => 'Một trường có 360 học sinh. 5/9 số học sinh là nam. Hỏi có bao nhiêu học sinh nữ?',
                    'options'     => ['140 học sinh', '150 học sinh', '160 học sinh', '170 học sinh'],
                    'answer'      => '160 học sinh',
                    'explanation' => 'Số học sinh nam: 360 × 5/9 = 200 học sinh. Số học sinh nữ: 360 - 200 = 160 học sinh.',
                    'level'       => 4
                ],
                [
                    'question'    => 'Một cửa hàng có 400 sản phẩm. 3/8 số sản phẩm đã bán hết. Hỏi còn lại bao nhiêu sản phẩm?',
                    'options'     => ['250 sản phẩm', '260 sản phẩm', '270 sản phẩm', '280 sản phẩm'],
                    'answer'      => '250 sản phẩm',
                    'explanation' => 'Số sản phẩm đã bán: 400 × 3/8 = 150 sản phẩm. Số sản phẩm còn lại: 400 - 150 = 250 sản phẩm.',
                    'level'       => 4
                ]
            ],
            5 => [
                [
                    'question'    => 'Một công ty có 500 nhân viên. 11/20 số nhân viên là nam. Hỏi có bao nhiêu nhân viên nữ?',
                    'options'     => ['200 nhân viên', '225 nhân viên', '250 nhân viên', '275 nhân viên'],
                    'answer'      => '225 nhân viên',
                    'explanation' => 'Số nhân viên nam: 500 × 11/20 = 275 nhân viên. Số nhân viên nữ: 500 - 275 = 225 nhân viên.',
                    'level'       => 5
                ],
                [
                    'question'    => 'Một trường có 600 học sinh. 13/24 số học sinh là nam. Hỏi có bao nhiêu học sinh nữ?',
                    'options'     => ['250 học sinh', '275 học sinh', '300 học sinh', '325 học sinh'],
                    'answer'      => '275 học sinh',
                    'explanation' => 'Số học sinh nam: 600 × 13/24 = 325 học sinh. Số học sinh nữ: 600 - 325 = 275 học sinh.',
                    'level'       => 5
                ],
                [
                    'question'    => 'Một cửa hàng có 720 sản phẩm. 7/18 số sản phẩm đã bán hết. Hỏi còn lại bao nhiêu sản phẩm?',
                    'options'     => ['440 sản phẩm', '460 sản phẩm', '480 sản phẩm', '500 sản phẩm'],
                    'answer'      => '440 sản phẩm',
                    'explanation' => 'Số sản phẩm đã bán: 720 × 7/18 = 280 sản phẩm. Số sản phẩm còn lại: 720 - 280 = 440 sản phẩm.',
                    'level'       => 5
                ]
            ]
        ];
    }
}
