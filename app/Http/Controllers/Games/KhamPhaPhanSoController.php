<?php

namespace App\Http\Controllers\Games;

class KhamPhaPhanSoController extends AbstractGroupGameController
{
    protected string $group = 'kham_pha_phan_so';

    // Apple Game - chỉ trả về view và data khởi tạo
    public function appleGame()
    {
        $questions = [
            1 => ['apples' => 4, 'students' => 2],
            2 => ['apples' => 6, 'students' => 3],
            3 => ['apples' => 8, 'students' => 4],
            4 => ['apples' => 10, 'students' => 5],
            5 => ['apples' => 12, 'students' => 6],
        ];
        return view('games.lop4.kham_pha_phan_so.apple', ['questions' => $questions]);
    }

    public function balanceGame()
    {
        $questions = [
            1 => [
                'left'           => ['numerator' => 1, 'denominator' => 2],
                'right'          => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '=',
                'valid_symbols'  => ['=']
            ],
            2 => [
                'left'           => ['numerator' => 3, 'denominator' => 4],
                'right'          => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '>',
                'valid_symbols'  => ['>']
            ],
            3 => [
                'left'           => ['numerator' => 2, 'denominator' => 6],
                'right'          => ['numerator' => 3, 'denominator' => 6],
                'correct_symbol' => '<',
                'valid_symbols'  => ['<']
            ],
            4 => [
                'left'           => ['numerator' => 4, 'denominator' => 8],
                'right'          => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '=',
                'valid_symbols'  => ['=']
            ],
            5 => [
                'left'           => ['numerator' => 5, 'denominator' => 6],
                'right'          => ['numerator' => 4, 'denominator' => 6],
                'correct_symbol' => '>',
                'valid_symbols'  => ['>']
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.balance', ['questions' => $questions]);
    }

    public function bracketGame()
    {
        $questions = [
            [
                'expression' => '(1/2 + 1/4)',
                'answer'     => ['numerator' => 3, 'denominator' => 4],
                'options'    => [
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 5, 'denominator' => 4]
                ]
            ],
            [
                'expression' => '(2/3 + 1/6)',
                'answer'     => ['numerator' => 5, 'denominator' => 6],
                'options'    => [
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 5, 'denominator' => 6],
                    ['numerator' => 1, 'denominator' => 1]
                ]
            ],
            [
                'expression' => '(3/4 - 1/4)',
                'answer'     => ['numerator' => 1, 'denominator' => 2],
                'options'    => [
                    ['numerator' => 1, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 1]
                ]
            ],
            [
                'expression' => '(1/2 + 1/3)',
                'answer'     => ['numerator' => 5, 'denominator' => 6],
                'options'    => [
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 5, 'denominator' => 6],
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 7, 'denominator' => 6]
                ]
            ],
            [
                'expression' => '(2/3 - 1/6)',
                'answer'     => ['numerator' => 1, 'denominator' => 2],
                'options'    => [
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 5, 'denominator' => 6]
                ]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.bracket', ['questions' => $questions]);
    }

    public function cakeGame()
    {
        $questions = [
            ['numerator' => 1, 'denominator' => 2],
            ['numerator' => 2, 'denominator' => 4],
            ['numerator' => 3, 'denominator' => 6],
            ['numerator' => 4, 'denominator' => 8],
            ['numerator' => 5, 'denominator' => 10],
        ];
        return view('games.lop4.kham_pha_phan_so.cake', ['questions' => $questions]);
    }

    public function cardsGame()
    {
        $questions = [
            1 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 1, 'denominator' => 2, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 2, 'denominator' => 4, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 1, 'denominator' => 3, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 2, 'denominator' => 6, 'pairId' => 2]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.5],
                    ['id' => 2, 'value' => 0.333]
                ]
            ],
            2 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 2, 'denominator' => 3, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 4, 'denominator' => 6, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 3, 'denominator' => 4, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 6, 'denominator' => 8, 'pairId' => 2],
                    ['id' => 5, 'numerator' => 1, 'denominator' => 5, 'pairId' => 3],
                    ['id' => 6, 'numerator' => 2, 'denominator' => 10, 'pairId' => 3]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.667],
                    ['id' => 2, 'value' => 0.75],
                    ['id' => 3, 'value' => 0.2]
                ]
            ],
            3 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 3, 'denominator' => 5, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 6, 'denominator' => 10, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 2, 'denominator' => 8, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 1, 'denominator' => 4, 'pairId' => 2],
                    ['id' => 5, 'numerator' => 4, 'denominator' => 6, 'pairId' => 3],
                    ['id' => 6, 'numerator' => 8, 'denominator' => 12, 'pairId' => 3]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.6],
                    ['id' => 2, 'value' => 0.25],
                    ['id' => 3, 'value' => 0.667]
                ]
            ],
            4 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 5, 'denominator' => 6, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 10, 'denominator' => 12, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 3, 'denominator' => 8, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 9, 'denominator' => 24, 'pairId' => 2],
                    ['id' => 5, 'numerator' => 7, 'denominator' => 10, 'pairId' => 3],
                    ['id' => 6, 'numerator' => 14, 'denominator' => 20, 'pairId' => 3],
                    ['id' => 7, 'numerator' => 1, 'denominator' => 6, 'pairId' => 4],
                    ['id' => 8, 'numerator' => 2, 'denominator' => 12, 'pairId' => 4]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.833],
                    ['id' => 2, 'value' => 0.375],
                    ['id' => 3, 'value' => 0.7],
                    ['id' => 4, 'value' => 0.167]
                ]
            ],
            5 => [
                'cards' => [
                    ['id' => 1, 'numerator' => 5, 'denominator' => 8, 'pairId' => 1],
                    ['id' => 2, 'numerator' => 15, 'denominator' => 24, 'pairId' => 1],
                    ['id' => 3, 'numerator' => 7, 'denominator' => 12, 'pairId' => 2],
                    ['id' => 4, 'numerator' => 35, 'denominator' => 60, 'pairId' => 2],
                    ['id' => 5, 'numerator' => 11, 'denominator' => 15, 'pairId' => 3],
                    ['id' => 6, 'numerator' => 22, 'denominator' => 30, 'pairId' => 3],
                    ['id' => 7, 'numerator' => 13, 'denominator' => 20, 'pairId' => 4],
                    ['id' => 8, 'numerator' => 39, 'denominator' => 60, 'pairId' => 4]
                ],
                'pairs' => [
                    ['id' => 1, 'value' => 0.625],
                    ['id' => 2, 'value' => 0.583],
                    ['id' => 3, 'value' => 0.733],
                    ['id' => 4, 'value' => 0.65]
                ]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.cards', ['questions' => $questions]);
    }

    public function compareGame()
    {
        $questions = [
            [
                'left'           => ['numerator' => 1, 'denominator' => 2],
                'right'          => ['numerator' => 2, 'denominator' => 4],
                'correct_symbol' => '='
            ],
            [
                'left'           => ['numerator' => 3, 'denominator' => 4],
                'right'          => ['numerator' => 2, 'denominator' => 3],
                'correct_symbol' => '>'
            ],
            [
                'left'           => ['numerator' => 2, 'denominator' => 5],
                'right'          => ['numerator' => 3, 'denominator' => 4],
                'correct_symbol' => '<'
            ],
            [
                'left'           => ['numerator' => 5, 'denominator' => 6],
                'right'          => ['numerator' => 7, 'denominator' => 8],
                'correct_symbol' => '<'
            ],
            [
                'left'           => ['numerator' => 4, 'denominator' => 5],
                'right'          => ['numerator' => 3, 'denominator' => 4],
                'correct_symbol' => '>'
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.compare', ['questions' => $questions]);
    }

    public function divisionGame()
    {
        $questions = [
            1 => [
                'dividend' => ['numerator' => 2, 'denominator' => 4],
                'divisor'  => ['numerator' => 1, 'denominator' => 2],
                'answers'  => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ],
            2 => [
                'dividend' => ['numerator' => 3, 'denominator' => 6],
                'divisor'  => ['numerator' => 1, 'denominator' => 2],
                'answers'  => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 3]
                ]
            ],
            3 => [
                'dividend' => ['numerator' => 4, 'denominator' => 8],
                'divisor'  => ['numerator' => 1, 'denominator' => 2],
                'answers'  => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ],
            4 => [
                'dividend' => ['numerator' => 6, 'denominator' => 9],
                'divisor'  => ['numerator' => 2, 'denominator' => 3],
                'answers'  => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 3]
                ]
            ],
            5 => [
                'dividend' => ['numerator' => 8, 'denominator' => 12],
                'divisor'  => ['numerator' => 2, 'denominator' => 3],
                'answers'  => [
                    ['numerator' => 1, 'denominator' => 1],
                    ['numerator' => 2, 'denominator' => 2],
                    ['numerator' => 4, 'denominator' => 4]
                ]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.division', ['questions' => $questions]);
    }

    // Equal Groups Game Methods
    public function equalGroupsGame()
    {
        $questions = [
            // Cấp 1: Cơ bản - Phân số đơn giản 1/2 và 1/3
            [
                'level'     => 1,
                'groups'    => [
                    ['id' => 1, 'name' => 'Nhóm 1/2'],
                    ['id' => 2, 'name' => 'Nhóm 1/3']
                ],
                'fractions' => [
                    ['id' => 1, 'text' => '2/4', 'group' => 1],
                    ['id' => 2, 'text' => '3/6', 'group' => 1],
                    ['id' => 3, 'text' => '4/8', 'group' => 1],
                    ['id' => 4, 'text' => '2/6', 'group' => 2],
                    ['id' => 5, 'text' => '3/9', 'group' => 2],
                    ['id' => 6, 'text' => '4/12', 'group' => 2]
                ]
            ],
            // Cấp 2: Phân số với mẫu số lớn hơn
            [
                'level'     => 2,
                'groups'    => [
                    ['id' => 1, 'name' => 'Nhóm 3/4'],
                    ['id' => 2, 'name' => 'Nhóm 2/3'],
                    ['id' => 3, 'name' => 'Nhóm 1/2']
                ],
                'fractions' => [
                    ['id' => 1, 'text' => '6/8', 'group' => 1],
                    ['id' => 2, 'text' => '9/12', 'group' => 1],
                    ['id' => 3, 'text' => '4/6', 'group' => 2],
                    ['id' => 4, 'text' => '8/12', 'group' => 2],
                    ['id' => 5, 'text' => '3/6', 'group' => 3],
                    ['id' => 6, 'text' => '4/8', 'group' => 3],
                    ['id' => 7, 'text' => '5/10', 'group' => 3]
                ]
            ],
            // Cấp 3: Ba nhóm với phân số phức tạp hơn
            [
                'level'     => 3,
                'groups'    => [
                    ['id' => 1, 'name' => 'Nhóm 5/6'],
                    ['id' => 2, 'name' => 'Nhóm 3/4'],
                    ['id' => 3, 'name' => 'Nhóm 2/3']
                ],
                'fractions' => [
                    ['id' => 1, 'text' => '10/12', 'group' => 1],
                    ['id' => 2, 'text' => '15/18', 'group' => 1],
                    ['id' => 3, 'text' => '9/12', 'group' => 2],
                    ['id' => 4, 'text' => '12/16', 'group' => 2],
                    ['id' => 5, 'text' => '8/12', 'group' => 3],
                    ['id' => 6, 'text' => '10/15', 'group' => 3],
                    ['id' => 7, 'text' => '14/21', 'group' => 3],
                ]
            ],
            // Cấp 4: Phân số với tử số lớn
            [
                'level'     => 4,
                'groups'    => [
                    ['id' => 1, 'name' => 'Nhóm 7/8'],
                    ['id' => 2, 'name' => 'Nhóm 4/5']
                ],
                'fractions' => [
                    ['id' => 1, 'text' => '14/16', 'group' => 1],
                    ['id' => 2, 'text' => '21/24', 'group' => 1],
                    ['id' => 3, 'text' => '28/32', 'group' => 1],
                    ['id' => 4, 'text' => '12/15', 'group' => 2],
                    ['id' => 5, 'text' => '16/20', 'group' => 2],
                    ['id' => 6, 'text' => '20/25', 'group' => 2],
                ]
            ],
            // Cấp 5: Thử thách
            [
                'level'     => 5,
                'groups'    => [
                    ['id' => 1, 'name' => 'Nhóm 5/8'],
                    ['id' => 2, 'name' => 'Nhóm 3/5'],
                    ['id' => 3, 'name' => 'Nhóm 7/12'],
                ],
                'fractions' => [
                    ['id' => 1, 'text' => '10/16', 'group' => 1],
                    ['id' => 2, 'text' => '15/24', 'group' => 1],
                    ['id' => 3, 'text' => '6/10', 'group' => 2],
                    ['id' => 4, 'text' => '9/15', 'group' => 2],
                    ['id' => 5, 'text' => '12/20', 'group' => 2],
                    ['id' => 6, 'text' => '14/24', 'group' => 3],
                    ['id' => 7, 'text' => '21/36', 'group' => 3],
                ]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.equal_groups', ['questions' => $questions]);
    }

    public function fairShare()
    {
        $questions = [
            [
                'level'         => 1,
                'total'         => ['numerator' => 4, 'denominator' => 5],
                'people'        => 2,
                'answer'        => ['numerator' => 2, 'denominator' => 5],
                'visualization' => [
                    'cake_parts' => 5,
                    'used_parts' => 4,
                ]
            ],
            [
                'level'         => 2,
                'total'         => ['numerator' => 3, 'denominator' => 4],
                'people'        => 3,
                'answer'        => ['numerator' => 1, 'denominator' => 4],
                'visualization' => [
                    'cake_parts' => 4,
                    'used_parts' => 3,
                ]
            ],
            [
                'level'         => 3,
                'total'         => ['numerator' => 2, 'denominator' => 3],
                'people'        => 4,
                'answer'        => ['numerator' => 1, 'denominator' => 6],
                'visualization' => [
                    'cake_parts' => 3,
                    'used_parts' => 2,
                ]
            ],
            [
                'level'         => 4,
                'total'         => ['numerator' => 5, 'denominator' => 6],
                'people'        => 2,
                'answer'        => ['numerator' => 5, 'denominator' => 12],
                'visualization' => [
                    'cake_parts' => 6,
                    'used_parts' => 5,
                ]
            ],
            [
                'level'         => 5,
                'total'         => ['numerator' => 3, 'denominator' => 5],
                'people'        => 6,
                'answer'        => ['numerator' => 1, 'denominator' => 10],
                'visualization' => [
                    'cake_parts' => 5,
                    'used_parts' => 3,
                ]
            ],
        ];
        return view('games.lop4.kham_pha_phan_so.fair_share', ['questions' => array_values($questions)]);
    }

    public function gardenGame()
    {
        $questions = [
            1 => [
                'numerator'             => 2,
                'denominator'           => 4,
                'simplifiedNumerator'   => 1,
                'simplifiedDenominator' => 2,
                'gridRows'              => 2,
                'gridCols'              => 2
            ],
            2 => [
                'numerator'             => 3,
                'denominator'           => 6,
                'simplifiedNumerator'   => 1,
                'simplifiedDenominator' => 2,
                'gridRows'              => 2,
                'gridCols'              => 3
            ],
            3 => [
                'numerator'             => 4,
                'denominator'           => 8,
                'simplifiedNumerator'   => 1,
                'simplifiedDenominator' => 2,
                'gridRows'              => 2,
                'gridCols'              => 4
            ],
            4 => [
                'numerator'             => 6,
                'denominator'           => 9,
                'simplifiedNumerator'   => 2,
                'simplifiedDenominator' => 3,
                'gridRows'              => 3,
                'gridCols'              => 3
            ],
            5 => [
                'numerator'             => 8,
                'denominator'           => 12,
                'simplifiedNumerator'   => 2,
                'simplifiedDenominator' => 3,
                'gridRows'              => 3,
                'gridCols'              => 4
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.garden', ['questions' => $questions]);
    }

    public function lostCityGame()
    {
        return view('games.lop4.kham_pha_phan_so.lost_city');
    }

    public function patternGame()
    {
        $questions = [
            [
                'sequence' => [
                    ['numerator' => 1, 'denominator' => 4],
                    ['numerator' => 2, 'denominator' => 4],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 4, 'denominator' => 4]
                ],
                'answer'   => ['numerator' => 5, 'denominator' => 4]
            ],
            [
                'sequence' => [
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 3, 'denominator' => 3],
                    ['numerator' => 4, 'denominator' => 3]
                ],
                'answer'   => ['numerator' => 5, 'denominator' => 3]
            ],
            [
                'sequence' => [
                    ['numerator' => 1, 'denominator' => 5],
                    ['numerator' => 2, 'denominator' => 5],
                    ['numerator' => 3, 'denominator' => 5],
                    ['numerator' => 4, 'denominator' => 5]
                ],
                'answer'   => ['numerator' => 5, 'denominator' => 5]
            ],
            [
                'sequence' => [
                    ['numerator' => 2, 'denominator' => 6],
                    ['numerator' => 3, 'denominator' => 6],
                    ['numerator' => 4, 'denominator' => 6],
                    ['numerator' => 5, 'denominator' => 6]
                ],
                'answer'   => ['numerator' => 6, 'denominator' => 6]
            ],
            [
                'sequence' => [
                    ['numerator' => 3, 'denominator' => 8],
                    ['numerator' => 4, 'denominator' => 8],
                    ['numerator' => 5, 'denominator' => 8],
                    ['numerator' => 6, 'denominator' => 8]
                ],
                'answer'   => ['numerator' => 7, 'denominator' => 8]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.pattern', ['questions' => $questions]);
    }

    public function remainingCakeGame()
    {
        $questions = [
            [
                'eaten'     => ['numerator' => 3, 'denominator' => 8],
                'remaining' => ['numerator' => 5, 'denominator' => 8]
            ],
            [
                'eaten'     => ['numerator' => 2, 'denominator' => 6],
                'remaining' => ['numerator' => 4, 'denominator' => 6]
            ],
            [
                'eaten'     => ['numerator' => 5, 'denominator' => 12],
                'remaining' => ['numerator' => 7, 'denominator' => 12]
            ],
            [
                'eaten'     => ['numerator' => 3, 'denominator' => 10],
                'remaining' => ['numerator' => 7, 'denominator' => 10]
            ],
            [
                'eaten'     => ['numerator' => 4, 'denominator' => 9],
                'remaining' => ['numerator' => 5, 'denominator' => 9]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.remaining_cake', ['questions' => $questions]);
    }

    public function sentenceGame()
    {
        $questions = [
            [
                'text'   => 'Một cái bánh được chia làm 4 phần bằng nhau. An ăn 1 phần, Bình ăn 2 phần. Hỏi An và Bình đã ăn bao nhiêu phần bánh?',
                'answer' => ['numerator' => 3, 'denominator' => 4],
                'hint'   => 'Cộng số phần bánh mà An và Bình đã ăn: 1/4 + 2/4 = 3/4'
            ],
            [
                'text'   => 'Một thanh chocolate được chia làm 6 phần bằng nhau. Mai ăn 2 phần, Lan ăn 3 phần. Hỏi Mai và Lan đã ăn bao nhiêu phần chocolate?',
                'answer' => ['numerator' => 5, 'denominator' => 6],
                'hint'   => 'Cộng số phần chocolate mà Mai và Lan đã ăn: 2/6 + 3/6 = 5/6'
            ],
            [
                'text'   => 'Một miếng pizza được chia làm 8 phần bằng nhau. Nam ăn 3 phần, Hoa ăn 2 phần. Hỏi Nam và Hoa đã ăn bao nhiêu phần pizza?',
                'answer' => ['numerator' => 5, 'denominator' => 8],
                'hint'   => 'Cộng số phần pizza mà Nam và Hoa đã ăn: 3/8 + 2/8 = 5/8'
            ],
            [
                'text'   => 'Một quả táo được chia làm 10 phần bằng nhau. Tùng ăn 4 phần, Thảo ăn 3 phần. Hỏi Tùng và Thảo đã ăn bao nhiêu phần táo?',
                'answer' => ['numerator' => 7, 'denominator' => 10],
                'hint'   => 'Cộng số phần táo mà Tùng và Thảo đã ăn: 4/10 + 3/10 = 7/10'
            ],
            [
                'text'   => 'Một cái bánh kem được chia làm 12 phần bằng nhau. Hùng ăn 5 phần, Minh ăn 4 phần. Hỏi Hùng và Minh đã ăn bao nhiêu phần bánh?',
                'answer' => ['numerator' => 9, 'denominator' => 12],
                'hint'   => 'Cộng số phần bánh mà Hùng và Minh đã ăn: 5/12 + 4/12 = 9/12'
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.sentence', ['questions' => $questions]);
    }

    public function skyGame()
    {
        $questions = [
            [
                'level'         => 1,
                'fractions'     => [
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 2, 'denominator' => 4],
                    ['numerator' => 3, 'denominator' => 4],
                ],
                'correct_index' => 2
            ],
            [
                'level'         => 2,
                'fractions'     => [
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 4, 'denominator' => 6],
                ],
                'correct_index' => 1
            ],
            [
                'level'         => 3,
                'fractions'     => [
                    ['numerator' => 5, 'denominator' => 6],
                    ['numerator' => 3, 'denominator' => 4],
                    ['numerator' => 7, 'denominator' => 8],
                ],
                'correct_index' => 2
            ],
            [
                'level'         => 4,
                'fractions'     => [
                    ['numerator' => 4, 'denominator' => 5],
                    ['numerator' => 5, 'denominator' => 6],
                    ['numerator' => 6, 'denominator' => 7],
                ],
                'correct_index' => 2
            ],
            [
                'level'         => 5,
                'fractions'     => [
                    ['numerator' => 7, 'denominator' => 8],
                    ['numerator' => 8, 'denominator' => 9],
                    ['numerator' => 9, 'denominator' => 10],
                ],
                'correct_index' => 2
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.sky', ['questions' => $questions]);
    }

    public function towerGame()
    {
        $questions = [
            [
                'level'        => 1,
                'fractions'    => [
                    ['numerator' => 1, 'denominator' => 4],
                    ['numerator' => 1, 'denominator' => 2],
                    ['numerator' => 3, 'denominator' => 4]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            [
                'level'        => 2,
                'fractions'    => [
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 2, 'denominator' => 3],
                    ['numerator' => 1, 'denominator' => 1]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            [
                'level'        => 3,
                'fractions'    => [
                    ['numerator' => 1, 'denominator' => 6],
                    ['numerator' => 1, 'denominator' => 3],
                    ['numerator' => 1, 'denominator' => 2]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            [
                'level'        => 4,
                'fractions'    => [
                    ['numerator' => 2, 'denominator' => 8],
                    ['numerator' => 3, 'denominator' => 8],
                    ['numerator' => 5, 'denominator' => 8]
                ],
                'correctOrder' => [0, 1, 2]
            ],
            [
                'level'        => 5,
                'fractions'    => [
                    ['numerator' => 1, 'denominator' => 5],
                    ['numerator' => 2, 'denominator' => 5],
                    ['numerator' => 3, 'denominator' => 5]
                ],
                'correctOrder' => [0, 1, 2]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.tower', ['questions' => $questions]);
    }

    public function wordHuntGame()
    {
        $questions = [
            [
                'level'   => 1,
                'hint'    => 'Săn lùng các phân số có giá trị bằng <strong>1/2</strong>',
                'options' => [
                    ['text' => '2/4', 'correct' => true],
                    ['text' => '5/10', 'correct' => true],
                    ['text' => '4/8', 'correct' => true],
                    ['text' => '3/6', 'correct' => true],
                    ['text' => '1/3', 'correct' => false],
                    ['text' => '2/3', 'correct' => false],
                    ['text' => '3/5', 'correct' => false],
                    ['text' => '6/10', 'correct' => false],
                ]
            ],
            [
                'level'   => 2,
                'hint'    => 'Tìm tất cả các phân số tương đương với <strong>2/3</strong>',
                'options' => [
                    ['text' => '4/6', 'correct' => true],
                    ['text' => '6/9', 'correct' => true],
                    ['text' => '8/12', 'correct' => true],
                    ['text' => '3/4', 'correct' => false],
                    ['text' => '1/2', 'correct' => false],
                    ['text' => '5/6', 'correct' => false],
                    ['text' => '9/12', 'correct' => false],
                ]
            ],
            [
                'level'   => 3,
                'hint'    => 'Những phân số nào bằng với <strong>3/4</strong>?',
                'options' => [
                    ['text' => '6/8', 'correct' => true],
                    ['text' => '9/12', 'correct' => true],
                    ['text' => '12/16', 'correct' => true],
                    ['text' => '2/3', 'correct' => false],
                    ['text' => '4/5', 'correct' => false],
                    ['text' => '5/8', 'correct' => false],
                    ['text' => '10/16', 'correct' => false],
                ]
            ],
            [
                'level'   => 4,
                'hint'    => 'Hãy chọn các phân số có giá trị là <strong>1/4</strong>',
                'options' => [
                    ['text' => '2/8', 'correct' => true],
                    ['text' => '3/12', 'correct' => true],
                    ['text' => '4/16', 'correct' => true],
                    ['text' => '1/5', 'correct' => false],
                    ['text' => '2/7', 'correct' => false],
                    ['text' => '3/11', 'correct' => false],
                    ['text' => '4/15', 'correct' => false],
                    ['text' => '5/20', 'correct' => true],
                ]
            ],
            [
                'level'   => 5,
                'hint'    => 'Đâu là những phân số rút gọn của <strong>12/18</strong>?',
                'options' => [
                    ['text' => '2/3', 'correct' => true],
                    ['text' => '4/6', 'correct' => true],
                    ['text' => '6/9', 'correct' => true],
                    ['text' => '8/12', 'correct' => true],
                    ['text' => '1/2', 'correct' => false],
                    ['text' => '3/4', 'correct' => false],
                    ['text' => '5/6', 'correct' => false],
                ]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.word_hunt', ['questions' => $questions]);
    }

    public function wordProblemGame()
    {
        $questions = [
            [
                'level'       => 1,
                'story'       => 'Một cái bánh được chia thành <strong>8</strong> phần bằng nhau. An ăn <strong>3</strong> phần, Bình ăn <strong>2</strong> phần. Hỏi còn lại bao nhiêu phần bánh?',
                'total_parts' => 8,
                'type'        => 'pie',
                'answer'      => ['numerator' => 3, 'denominator' => 8]
            ],
            [
                'level'       => 2,
                'story'       => 'Một miếng pizza được chia thành <strong>6</strong> phần bằng nhau. Mai ăn <strong>2</strong> phần, Lan ăn <strong>1</strong> phần. Hỏi còn lại bao nhiêu phần pizza?',
                'total_parts' => 6,
                'type'        => 'pie',
                'answer'      => ['numerator' => 3, 'denominator' => 6]
            ],
            [
                'level'       => 3,
                'story'       => 'Một thanh chocolate được chia thành <strong>10</strong> phần bằng nhau. Nam ăn <strong>4</strong> phần, Hoa ăn <strong>3</strong> phần. Hỏi còn lại bao nhiêu phần chocolate?',
                'total_parts' => 10,
                'type'        => 'bar',
                'answer'      => ['numerator' => 3, 'denominator' => 10]
            ],
            [
                'level'       => 4,
                'story'       => 'Một quả táo được chia thành <strong>4</strong> phần bằng nhau. Hùng ăn <strong>1</strong> phần, Minh ăn <strong>1</strong> phần. Hỏi còn lại bao nhiêu phần táo?',
                'total_parts' => 4,
                'type'        => 'pie',
                'answer'      => ['numerator' => 2, 'denominator' => 4]
            ],
            [
                'level'       => 5,
                'story'       => 'Một cái bánh kem được chia thành <strong>12</strong> phần bằng nhau. Tùng ăn <strong>3</strong> phần, Thảo ăn <strong>4</strong> phần. Hỏi còn lại bao nhiêu phần bánh?',
                'total_parts' => 12,
                'type'        => 'pie',
                'answer'      => ['numerator' => 5, 'denominator' => 12]
            ]
        ];
        return view('games.lop4.kham_pha_phan_so.word_problem', ['questions' => $questions]);
    }
}
