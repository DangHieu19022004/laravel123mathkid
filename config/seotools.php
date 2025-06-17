<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'Game Toán Lớp 4 - Học Toán Qua Trò Chơi Tương Tác', // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Khám phá thế giới toán học thú vị với các trò chơi tương tác giúp học sinh lớp 4 rèn luyện kỹ năng tính toán và tư duy logic một cách hiệu quả.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['game toán lớp 4', 'học toán qua trò chơi', 'phân số', 'hình học', 'đo lường', 'thống kê', 'dãy số quy luật', 'giải toán có lời văn'],
            'canonical'    => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Game Toán Lớp 4 - Học Toán Qua Trò Chơi Tương Tác', // set false to total remove
            'description' => 'Khám phá thế giới toán học thú vị với các trò chơi tương tác giúp học sinh lớp 4 rèn luyện kỹ năng tính toán và tư duy logic một cách hiệu quả.', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => 'website',
            'site_name'   => 'Game Toán Lớp 4',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Game Toán Lớp 4 - Học Toán Qua Trò Chơi Tương Tác', // set false to total remove
            'description' => 'Khám phá thế giới toán học thú vị với các trò chơi tương tác giúp học sinh lớp 4 rèn luyện kỹ năng tính toán và tư duy logic một cách hiệu quả.', // set false to total remove
            'url'         => false, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'EducationalApplication',
            'images'      => [],
        ],
    ],
];
