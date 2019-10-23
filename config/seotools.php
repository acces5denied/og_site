<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "OGHome - Полный спектр услуг по продаже элитной недвижимости в Москве.", // set false to total remove
            'description'  => 'OGHome - Агентство элитной недвижимости. Продажа, подбор, консультация по эксклюзивным квартирам, апартаментам и пентхаусам в Москве.', // set false to total remove
            'separator'    => ' | ',
            'keywords'     => ['элитная недвижимость', 'продажа элитных квартир', 'элитные квартиры', 'апартаменты', 'пентхаусы', 'таунхаусы', 'агенство недвижимости'],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
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
            'yandex'    => 'ce3f0c3e8a100d19',
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'OGHome - Полный спектр услуг по продаже элитной недвижимости в Москве. Крупнейшая база эксклюзивных предложений.', // set false to total remove
            'description' => 'OGHome - Агентство элитной недвижимости. Продажа, подбор, консультация по эксклюзивным квартирам, апартаментам и пентхаусам в Москве.', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => 'OGHome',
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
];