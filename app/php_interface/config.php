<?php
return [
    'id' => 'basic',
    'charset' => 'utf-8',
    'site_online' => true,
    'default_lang' => 'ru',
    'site_name' => 'Reagordi Basic',
    'robots_access' => 'index,follow',
    'show_author' => false,
    'theme' => [
        'site' => '.default',
        'admin' => '.default'
    ],
    'cache' => [
        'status' => false,
        'lifetime' => 60
    ],
    'optimize' => [
        'gzip_css' => true,
        'gzip_js' => false,
        'gzip_html' => false,
    ],
    'modules' => [

    ],
    'version' => '1.0'
];