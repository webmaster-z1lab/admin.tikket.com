<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 19/11/2018
 * Time: 18:10
 */
return [
    'cdn_url' => str_finish(env('AWS_CDN_ENDPOINT', 'https://cdn.z1lab.com.br'), '/'),
    'css'     => [],
    'js'      => [],
    'js-defer' => [],
    'prod'    => [
        'namespace' => '',
        'version'   => '',
    ],
];
