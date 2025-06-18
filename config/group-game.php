<?php

return [
    'lop4' => [
        'title'       => 'Game Toán Lớp 4',
        'description' => 'Khám phá thế giới toán học thú vị với các trò chơi tương tác giúp học sinh lớp 4 rèn luyện kỹ năng tính toán và tư duy logic một cách hiệu quả.',
        'route'       => 'game.lop4.tong_quan',
        'group-game'  => [
            'so_tu_nhien'        => [
                'icon'        => '🔢',
                'title'       => 'Số Tự Nhiên và Các Phép Tính',
                'description' => 'Rèn luyện kỹ năng thực hiện các phép tính cơ bản với số tự nhiên thông qua các trò chơi tương tác giúp học sinh nắm vững kiến thức toán học.',
                'route'       => 'game.lop4.so_tu_nhien_va_cac_phep_tinh.tong_quan',
                'games'       => [

                ],
            ],
            'kham_pha_phan_so'            => [
                'icon'        => '🥧',
                'title'       => 'Khám Phá Thế Giới Phân Số',
                'description' => 'Khám phá thế giới phân số qua các trò chơi thú vị giúp hiểu rõ về phần, so sánh và thực hiện các phép tính với phân số một cách dễ dàng.',
                'route'       => 'game.lop4.kham_pha_phan_so.tong_quan',
                'games'       => [
                    'qua_tao'          => [
                        'icon'        => '🍏',
                        'title'       => 'Chia Táo',
                        'description' => 'Cùng chia những quả táo thơm ngon! Rèn luyện cách chia vật thể thành các phần bằng nhau, đặt nền móng vững chắc cho khái niệm phân số.',
                        'route'       => 'game.lop4.kham_pha_phan_so.qua_tao',
                    ],
                    'can_bang'         => [
                        'icon'        => '⚖️',
                        'title'       => 'Cân Bằng',
                        'description' => 'Thử thách cân não với phân số! Đặt các phân số lên cân và tìm ra dấu đúng để duy trì sự cân bằng, chứng tỏ bạn là bậc thầy so sánh phân số.',
                        'route'       => 'game.lop4.kham_pha_phan_so.can_bang',
                    ],
                    'dau_ngoac'        => [
                        'icon'        => '🧩',
                        'title'       => 'Điền Dấu Ngoặc',
                        'description' => 'Khám phá phép thuật của dấu ngoặc! Lắp ghép chúng vào đúng vị trí để giải mã các biểu thức phân số phức tạp.',
                        'route'       => 'game.lop4.kham_pha_phan_so.dau_ngoac',
                    ],
                    'banh_ngot'        => [
                        'icon'        => '🍰',
                        'title'       => 'Chia Bánh',
                        'description' => 'Cùng nhau chia sẻ những chiếc bánh ngọt ngào! Học cách chia bánh thành các phần đều nhau để mọi người đều vui vẻ.',
                        'route'       => 'game.lop4.kham_pha_phan_so.banh_ngot',
                    ],
                    'the_bai'          => [
                        'icon'        => '🃏',
                        'title'       => 'Thẻ Bài Phân Số',
                        'description' => 'Vào vai thám tử phân số! Nhanh tay kết nối các cặp thẻ bài ẩn chứa phân số tương đương để chinh phục thử thách và mở khóa bí mật.',
                        'route'       => 'game.lop4.kham_pha_phan_so.the_bai',
                    ],
                    'so_sanh'          => [
                        'icon'        => '🔍',
                        'title'       => 'So Sánh Phân Số',
                        'description' => 'Trở thành chuyên gia so sánh! Khám phá xem phân số nào lớn hơn, nhỏ hơn hay bằng nhau qua các màn chơi đầy thử thách.',
                        'route'       => 'game.lop4.kham_pha_phan_so.so_sanh',
                    ],
                    'phep_chia'        => [
                        'icon'        => '➗',
                        'title'       => 'Chia Phân Số',
                        'description' => 'Giải mã bí ẩn phép chia phân số! Thực hành các bài toán chia phân số trong các tình huống thực tế vui nhộn.',
                        'route'       => 'game.lop4.kham_pha_phan_so.phep_chia',
                    ],
                    'nhom_bang_nhau'   => [
                        'icon'        => '👥',
                        'title'       => 'Nhóm Phân Số Bằng Nhau',
                        'description' => 'Kết nối những người bạn phân số! Phân loại và nhóm các phân số có giá trị tương đương vào đúng vị trí.',
                        'route'       => 'game.lop4.kham_pha_phan_so.nhom_bang_nhau',
                    ],
                    'chia_deu'         => [
                        'icon'        => '🎯',
                        'title'       => 'Chia Đều',
                        'description' => 'Thử thách công bằng! Chia đều mọi thứ cho tất cả mọi người để không ai phải tị nạnh, rèn luyện tư duy chia phần.',
                        'route'       => 'game.lop4.kham_pha_phan_so.chia_deu',
                    ],
                    'vuon_hoa'         => [
                        'icon'        => '🌱',
                        'title'       => 'Vườn Phân Số',
                        'description' => 'Trồng cây xanh với phân số! Sắp xếp và kết hợp các phân số để tạo nên khu vườn toán học tươi tốt.',
                        'route'       => 'game.lop4.kham_pha_phan_so.vuon_hoa',
                    ],
                    'thanh_pho_bi_an'  => [
                        'icon'        => '🏙️',
                        'title'       => 'Thành Phố Mất Tích',
                        'description' => 'Giải mã các câu đố phân số để tìm đường thoát khỏi Thành Phố Mất Tích đầy bí ẩn và thử thách.',
                        'route'       => 'game.lop4.kham_pha_phan_so.thanh_pho_bi_an',
                    ],
                    'quy_luat'         => [
                        'icon'        => '🔢',
                        'title'       => 'Dãy Quy Luật',
                        'description' => 'Khám phá các quy luật ẩn giấu! Tìm ra chuỗi phân số logic và hoàn thành dãy số để mở khóa cấp độ mới.',
                        'route'       => 'game.lop4.kham_pha_phan_so.quy_luat',
                    ],
                    'phan_so'          => [
                        'icon'        => '🔣',
                        'title'       => 'Phân Số Tổng Hợp',
                        'description' => 'Tổng hợp mọi kiến thức về phân số! Ôn luyện và nâng cao kỹ năng qua các dạng bài tập đa dạng và thú vị.',
                        'route'       => 'game.lop4.kham_pha_phan_so.phan_so',
                    ],
                    'banh_con_lai'     => [
                        'icon'        => '🍩',
                        'title'       => 'Miếng Bánh Cuối Cùng',
                        'description' => 'Giải cứu miếng bánh cuối cùng! Sử dụng kiến thức phân số để tính toán và tìm ra phần bánh còn lại sau khi chia.',
                        'route'       => 'game.lop4.kham_pha_phan_so.banh_con_lai',
                    ],
                    'ghep_cau'         => [
                        'icon'        => '✍️',
                        'title'       => 'Ghép Câu Phân Số',
                        'description' => 'Sáng tạo câu chuyện với phân số! Nối các cụm từ và phân số để tạo thành những câu có nghĩa và logic.',
                        'route'       => 'game.lop4.kham_pha_phan_so.ghep_cau',
                    ],
                    'bau_troi'         => [
                        'icon'        => '☁️',
                        'title'       => 'Bầu Trời Phân Số',
                        'description' => 'Bay lượn trên bầu trời toán học! Khám phá và tương tác với các phân số bay lượn để hoàn thành nhiệm vụ.',
                        'route'       => 'game.lop4.kham_pha_phan_so.bau_troi',
                    ],
                    'thap_phan_so'     => [
                        'icon'        => '🏰',
                        'title'       => 'Tháp Phân Số',
                        'description' => 'Xây dựng ngọn tháp cao nhất! Sắp xếp các khối phân số theo đúng thứ tự để tạo nên một tòa tháp vững chắc.',
                        'route'       => 'game.lop4.kham_pha_phan_so.thap_phan_so',
                    ],
                    'san_tu'           => [
                        'icon'        => '🔎',
                        'title'       => 'Săn Từ Phân Số',
                        'description' => 'Trở thành thợ săn từ! Tìm kiếm và khám phá những từ khóa liên quan đến phân số ẩn giấu trong mê cung chữ cái.',
                        'route'       => 'game.lop4.kham_pha_phan_so.san_tu',
                    ],
                    'bai_toan_loi_van' => [
                        'icon'        => '📖',
                        'title'       => 'Bài Toán Lời Văn',
                        'description' => 'Vượt qua thử thách! Giải quyết các bài toán có lời văn đầy thú vị liên quan đến phân số trong các tình huống đời thường.',
                        'route'       => 'game.lop4.kham_pha_phan_so.bai_toan_loi_van',
                    ],
                ],
            ],
            'hinh-hoc'           => [
                'icon'        => '📐',
                'title'       => 'Bí Ẩn Hình Học',
                'description' => 'Giải mã các bí ẩn hình học thông qua việc tính chu vi, diện tích và thể tích của các hình khối khác nhau trong môi trường học tập tương tác.',
                'route'       => 'game.lop4.bi_an_hinh_hoc.tong_quan',
                'games'       => [

                ],
            ],
            'do_luong_va_don_vi' => [
                'icon'        => '📏⚖️⏳',
                'title'       => 'Thử Thách Đo Lường',
                'description' => 'Tham gia các thử thách đo lường về độ dài, khối lượng, thời gian và dung tích với các đơn vị đo khác nhau để rèn luyện kỹ năng thực tế.',
                'route'       => 'game.lop4.thu_thach_do_luong.tong_quan',
                'games'       => [

                ],
            ],
            'giai_toan_loi_van'  => [
                'icon'        => '💡',
                'title'       => 'Giải Toán Có Lời Văn Siêu Đẳng',
                'description' => 'Phát triển tư duy logic và kỹ năng giải quyết vấn đề thông qua các bài toán có lời văn với nhiều tình huống thực tế đa dạng và thú vị.',
                'route'       => 'game.lop4.giai_toan_loi_van.tong_quan',
                'games'       => [

                ],
            ],
            'thong_ke_bieu_do'   => [
                'icon'        => '📊',
                'title'       => 'Thống Kê: Biểu đồ và Số liệu',
                'description' => 'Học cách đọc, hiểu và phân tích dữ liệu thống kê thông qua các biểu đồ trực quan giúp phát triển kỹ năng phân tích và suy luận.',
                'route'       => 'game.lop4.thong_ke_bieu_do.tong_quan',
                'games'       => [

                ],
            ],
            'day_so_quy_luat'    => [
                'icon'        => '🧠',
                'title'       => 'Dãy Số Có Quy Luật',
                'description' => 'Khám phá các quy luật toán học thú vị trong dãy số, rèn luyện khả năng quan sát, phân tích và dự đoán các mẫu số học một cách logic.',
                'route'       => 'game.lop4.day_so_quy_luat.tong_quan',
                'games'       => [

                ],
            ]
        ]
    ]
];
