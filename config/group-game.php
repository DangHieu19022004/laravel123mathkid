<?php

return [
    'lop4' => [
        'title'       => 'Game Toán Lớp 4',
        'description' => 'Khám phá thế giới toán học thú vị với các trò chơi tương tác giúp học sinh lớp 4 rèn luyện kỹ năng tính toán và tư duy logic một cách hiệu quả.',
        'route'       => 'game.lop4.overview',
        'group-game'  => [
            'so_tu_nhien_va_cac_phep_tinh' => [
                'icon'        => '🔢',
                'title'       => 'Số Tự Nhiên và Các Phép Tính',
                'description' => 'Rèn luyện kỹ năng thực hiện các phép tính cơ bản với số tự nhiên thông qua các trò chơi tương tác giúp học sinh nắm vững kiến thức toán học.',
                'route'       => 'game.lop4.natural_numbers_and_operations.overview',
                'games'       => [
                    'gia_tri_hang'      => [
                        'icon'        => '🔍',
                        'title'       => 'Giá Trị Hàng',
                        'description' => 'Khám phá giá trị các hàng trong số tự nhiên một cách trực quan.',
                        'route'       => 'game.lop4.natural_numbers_and_operations.number_place_value',
                    ],
                    'cong_tru'          => [
                        'icon'        => '➕➖',
                        'title'       => 'Cộng Trừ',
                        'description' => 'Luyện tập phép cộng và phép trừ với số tự nhiên.',
                        'route'       => 'game.lop4.natural_numbers_and_operations.addition_subtraction',
                    ],
                    'nhan_chia'         => [
                        'icon'        => '✖️➗',
                        'title'       => 'Nhân Chia',
                        'description' => 'Luyện tập phép nhân và phép chia số tự nhiên.',
                        'route'       => 'game.lop4.natural_numbers_and_operations.multiplication_division',
                    ],
                    'phep_tinh_hon_hop' => [
                        'icon'        => '🧮',
                        'title'       => 'Phép Tính Hỗn Hợp',
                        'description' => 'Thực hành các phép tính kết hợp nhanh, chính xác.',
                        'route'       => 'game.lop4.natural_numbers_and_operations.mixed_operations',
                    ],
                ],
            ],
            'kham_pha_phan_so'             => [
                'icon'        => '🥧',
                'title'       => 'Khám Phá Thế Giới Phân Số',
                'description' => 'Khám phá thế giới phân số qua các trò chơi thú vị giúp hiểu rõ về phần, so sánh và thực hiện các phép tính với phân số một cách dễ dàng.',
                'route'       => 'game.lop4.fraction_exploration.overview',
                'games'       => [
                    'qua_tao'          => [
                        'icon'        => '🍏',
                        'title'       => 'Chia Táo',
                        'description' => 'Cùng chia những quả táo thơm ngon! Rèn luyện cách chia vật thể thành các phần bằng nhau, đặt nền móng vững chắc cho khái niệm phân số.',
                        'route'       => 'game.lop4.fraction_exploration.apple',
                    ],
                    'can_bang'         => [
                        'icon'        => '⚖️',
                        'title'       => 'Cân Bằng',
                        'description' => 'Thử thách cân não với phân số! Đặt các phân số lên cân và tìm ra dấu đúng để duy trì sự cân bằng, chứng tỏ bạn là bậc thầy so sánh phân số.',
                        'route'       => 'game.lop4.fraction_exploration.balance',
                    ],
                    'dau_ngoac'        => [
                        'icon'        => '🧩',
                        'title'       => 'Điền Dấu Ngoặc',
                        'description' => 'Khám phá phép thuật của dấu ngoặc! Lắp ghép chúng vào đúng vị trí để giải mã các biểu thức phân số phức tạp.',
                        'route'       => 'game.lop4.fraction_exploration.bracket',
                    ],
                    'banh_ngot'        => [
                        'icon'        => '🍰',
                        'title'       => 'Chia Bánh',
                        'description' => 'Cùng nhau chia sẻ những chiếc bánh ngọt ngào! Học cách chia bánh thành các phần đều nhau để mọi người đều vui vẻ.',
                        'route'       => 'game.lop4.fraction_exploration.cake',
                    ],
                    'the_bai'          => [
                        'icon'        => '🃏',
                        'title'       => 'Thẻ Bài Phân Số',
                        'description' => 'Vào vai thám tử phân số! Nhanh tay kết nối các cặp thẻ bài ẩn chứa phân số tương đương để chinh phục thử thách và mở khóa bí mật.',
                        'route'       => 'game.lop4.fraction_exploration.cards',
                    ],
                    'so_sanh'          => [
                        'icon'        => '🔍',
                        'title'       => 'So Sánh Phân Số',
                        'description' => 'Trở thành chuyên gia so sánh! Khám phá xem phân số nào lớn hơn, nhỏ hơn hay bằng nhau qua các màn chơi đầy thử thách.',
                        'route'       => 'game.lop4.fraction_exploration.compare',
                    ],
                    'phep_chia'        => [
                        'icon'        => '➗',
                        'title'       => 'Chia Phân Số',
                        'description' => 'Giải mã bí ẩn phép chia phân số! Thực hành các bài toán chia phân số trong các tình huống thực tế vui nhộn.',
                        'route'       => 'game.lop4.fraction_exploration.division',
                    ],
                    'nhom_bang_nhau'   => [
                        'icon'        => '👥',
                        'title'       => 'Nhóm Phân Số Bằng Nhau',
                        'description' => 'Kết nối những người bạn phân số! Phân loại và nhóm các phân số có giá trị tương đương vào đúng vị trí.',
                        'route'       => 'game.lop4.fraction_exploration.equal_groups',
                    ],
                    'chia_deu'         => [
                        'icon'        => '🎯',
                        'title'       => 'Chia Đều',
                        'description' => 'Thử thách công bằng! Chia đều mọi thứ cho tất cả mọi người để không ai phải tị nạnh, rèn luyện tư duy chia phần.',
                        'route'       => 'game.lop4.fraction_exploration.fair_share',
                    ],
                    'vuon_hoa'         => [
                        'icon'        => '🌱',
                        'title'       => 'Vườn Phân Số',
                        'description' => 'Trồng cây xanh với phân số! Sắp xếp và kết hợp các phân số để tạo nên khu vườn toán học tươi tốt.',
                        'route'       => 'game.lop4.fraction_exploration.garden',
                    ],
                    'thanh_pho_bi_an'  => [
                        'icon'        => '🏙️',
                        'title'       => 'Thành Phố Mất Tích',
                        'description' => 'Giải mã các câu đố phân số để tìm đường thoát khỏi Thành Phố Mất Tích đầy bí ẩn và thử thách.',
                        'route'       => 'game.lop4.fraction_exploration.lost_city',
                    ],
                    'quy_luat'         => [
                        'icon'        => '🔢',
                        'title'       => 'Dãy Quy Luật',
                        'description' => 'Khám phá các quy luật ẩn giấu! Tìm ra chuỗi phân số logic và hoàn thành dãy số để mở khóa cấp độ mới.',
                        'route'       => 'game.lop4.fraction_exploration.pattern',
                    ],
                    'phan_so'          => [
                        'icon'        => '🔣',
                        'title'       => 'Phân Số Tổng Hợp',
                        'description' => 'Tổng hợp mọi kiến thức về phân số! Ôn luyện và nâng cao kỹ năng qua các dạng bài tập đa dạng và thú vị.',
                        'route'       => 'game.lop4.fraction_exploration.fraction',
                    ],
                    'banh_con_lai'     => [
                        'icon'        => '🍩',
                        'title'       => 'Miếng Bánh Cuối Cùng',
                        'description' => 'Giải cứu miếng bánh cuối cùng! Sử dụng kiến thức phân số để tính toán và tìm ra phần bánh còn lại sau khi chia.',
                        'route'       => 'game.lop4.fraction_exploration.remaining_cake',
                    ],
                    'ghep_cau'         => [
                        'icon'        => '✍️',
                        'title'       => 'Ghép Câu Phân Số',
                        'description' => 'Sáng tạo câu chuyện với phân số! Nối các cụm từ và phân số để tạo thành những câu có nghĩa và logic.',
                        'route'       => 'game.lop4.fraction_exploration.sentence',
                    ],
                    'bau_troi'         => [
                        'icon'        => '☁️',
                        'title'       => 'Bầu Trời Phân Số',
                        'description' => 'Bay lượn trên bầu trời toán học! Khám phá và tương tác với các phân số bay lượn để hoàn thành nhiệm vụ.',
                        'route'       => 'game.lop4.fraction_exploration.sky',
                    ],
                    'thap_phan_so'     => [
                        'icon'        => '🏰',
                        'title'       => 'Tháp Phân Số',
                        'description' => 'Xây dựng ngọn tháp cao nhất! Sắp xếp các khối phân số theo đúng thứ tự để tạo nên một tòa tháp vững chắc.',
                        'route'       => 'game.lop4.fraction_exploration.tower',
                    ],
                    'san_tu'           => [
                        'icon'        => '🔎',
                        'title'       => 'Săn Từ Phân Số',
                        'description' => 'Trở thành thợ săn từ! Tìm kiếm và khám phá những từ khóa liên quan đến phân số ẩn giấu trong mê cung chữ cái.',
                        'route'       => 'game.lop4.fraction_exploration.word_hunt',
                    ],
                    'bai_toan_loi_van' => [
                        'icon'        => '📖',
                        'title'       => 'Bài Toán Lời Văn',
                        'description' => 'Vượt qua thử thách! Giải quyết các bài toán có lời văn đầy thú vị liên quan đến phân số trong các tình huống đời thường.',
                        'route'       => 'game.lop4.fraction_exploration.word_problem',
                    ],
                ],
            ],
            'bi_an_hinh_hoc'               => [
                'icon'        => '📐',
                'title'       => 'Bí Ẩn Hình Học',
                'description' => 'Giải mã các bí ẩn hình học thông qua việc tính chu vi, diện tích và thể tích của các hình khối khác nhau trong môi trường học tập tương tác.',
                'route'       => 'game.lop4.geometry_mysteries.overview',
                'games'       => [
                    'dien_tich'    => [
                        'icon'        => '🟥',
                        'title'       => 'Tính Diện Tích',
                        'description' => 'Tính diện tích các hình cơ bản qua ví dụ trực quan, dễ hiểu.',
                        'route'       => 'game.lop4.geometry_mysteries.area_calculation',
                    ],
                    'chu_vi'       => [
                        'icon'        => '📏',
                        'title'       => 'Tính Chu Vi',
                        'description' => 'Ôn tập cách tính chu vi các hình học thường gặp.',
                        'route'       => 'game.lop4.geometry_mysteries.perimeter_calculation',
                    ],
                    'do_goc'       => [
                        'icon'        => '📐',
                        'title'       => 'Đo Góc',
                        'description' => 'Đo và ước lượng góc bằng các công cụ quen thuộc.',
                        'route'       => 'game.lop4.geometry_mysteries.angle_measurement',
                    ],
                    'do_dung_tich' => [
                        'icon'        => '🥛',
                        'title'       => 'Đo Dung Tích',
                        'description' => 'Khám phá cách đo và so sánh dung tích các vật dụng.',
                        'route'       => 'game.lop4.geometry_mysteries.volume_measurement',
                    ],
                    //                    'do_dien_tich' => [
                    //                        'icon'        => '🟦📏',
                    //                        'title'       => 'Đo Diện Tích',
                    //                        'description' => 'Chọn hình có diện tích lớn nhất/nhỏ nhất.',
                    //                        'route'       => 'game.lop4.geometry_mysteries.area_measurement',
                    //                    ]
                ],
            ],
            'thu_thach_do_luong'           => [
                'icon'        => '📏⚖️⏳',
                'title'       => 'Thử Thách Đo Lường',
                'description' => 'Tham gia các thử thách đo lường về độ dài, khối lượng, thời gian và dung tích với các đơn vị đo khác nhau để rèn luyện kỹ năng thực tế.',
                'route'       => 'game.lop4.measurement_challenges.overview',
                'games'       => [

                ],
            ],
            'giai_toan_loi_van'            => [
                'icon'        => '💡',
                'title'       => 'Giải Toán Có Lời Văn Siêu Đẳng',
                'description' => 'Phát triển tư duy logic và kỹ năng giải quyết vấn đề thông qua các bài toán có lời văn với nhiều tình huống thực tế đa dạng và thú vị.',
                'route'       => 'game.lop4.word_problem_solving.overview',
                'games'       => [
                    'thanh_pho_bi_an'  => [
                        'icon'        => '🏰',
                        'title'       => 'Thành Phố Bí Ẩn',
                        'description' => 'Khám phá thành phố cổ đầy bí ẩn! Giải các bài toán để mở khóa từng con đường và khôi phục vẻ đẹp của thành phố đã bị lãng quên.',
                        'route'       => 'game.lop4.word_problem_solving.lost_city',
                    ],
                    'bai_toan_loi_van' => [
                        'icon'        => '📚',
                        'title'       => 'Bài Toán Lời Văn',
                        'description' => 'Rèn luyện tư duy logic qua các tình huống thực tế! Giải các bài toán về phân số trong cuộc sống hàng ngày, từ chia bánh đến tính toán thời gian.',
                        'route'       => 'game.lop4.word_problem_solving.word_problem',
                    ],
                ],
            ],
            'thong_ke_bieu_do'             => [
                'icon'        => '📊',
                'title'       => 'Thống Kê: Biểu đồ và Số liệu',
                'description' => 'Học cách đọc, hiểu và phân tích dữ liệu thống kê thông qua các biểu đồ trực quan giúp phát triển kỹ năng phân tích và suy luận.',
                'route'       => 'game.lop4.statistics_and_charts.overview',
                'games'       => [
                    'thu_thap_du_lieu' => [
                        'icon'        => '📝',
                        'title'       => 'Thu Thập Dữ Liệu',
                        'description' => 'Thu thập và sắp xếp dữ liệu một cách trực quan, dễ hiểu.',
                        'route'       => 'game.lop4.statistics_and_charts.data_collection',
                    ],
                    'bieu_do_cot'      => [
                        'icon'        => '📊',
                        'title'       => 'Biểu Đồ Cột',
                        'description' => 'Khám phá cách đọc và vẽ biểu đồ cột đơn giản, sinh động.',
                        'route'       => 'game.lop4.statistics_and_charts.bar_chart',
                    ],
                    'bieu_do_duong'    => [
                        'icon'        => '📈',
                        'title'       => 'Biểu Đồ Đường',
                        'description' => 'Làm quen với biểu đồ đường qua các ví dụ trực quan, dễ nhớ.',
                        'route'       => 'game.lop4.statistics_and_charts.line_chart',
                    ],
                    'bieu_do_tron'     => [
                        'icon'        => '🥧',
                        'title'       => 'Biểu Đồ Tròn',
                        'description' => 'Tìm hiểu biểu đồ tròn và cách thể hiện dữ liệu bằng hình ảnh.',
                        'route'       => 'game.lop4.statistics_and_charts.pie_chart',
                    ],
                ],
            ],
            'day_so_quy_luat'              => [
                'icon'        => '🧠',
                'title'       => 'Dãy Số Có Quy Luật',
                'description' => 'Khám phá các quy luật toán học thú vị trong dãy số, rèn luyện khả năng quan sát, phân tích và dự đoán các mẫu số học một cách logic.',
                'route'       => 'game.lop4.number_sequence_patterns.overview',
                'games'       => [

                ],
            ]
        ]
    ]
];
