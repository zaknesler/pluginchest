<?php

return [

    'storage' => [
        'temporary' => env('FILE_DISK_TEMP', 'plugin-files-temporary'),
        'validated' => env('FILE_DISK_VALID', 'plugin-files'),
    ],

    'game_versions' => [
        '1.13.1',
        '1.13',
        '1.12.2',
        '1.12.1',
        '1.12',
        '1.11.2',
        '1.11',
        '1.10.2',
        '1.10',
        '1.9',
        '1.8.2',
        '1.8.1',
        '1.8',
        '1.7.10',
    ],

    'file_stages' => [
        'alpha',
        'beta',
        'release',
    ],

    // TODO: implement roles column in plugin users table
    'plugin_roles' => [
        'owner',
        'author',
    ],

];
