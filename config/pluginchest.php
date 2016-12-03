<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Game Versions
    |--------------------------------------------------------------------------
    |
    | Here is a list of Minecraft game versions that a user can choose from
    | when creating a new plugin. This is also used in the validation of
    | a plugin file. This will be updated for every Minecraft release.
    |
    */

    'game_versions' => [
        '1.11',
        '1.10.2',
        '1.10',
        '1.9',
        '1.8.2',
        '1.8.1',
        '1.8',
        '1.7.10',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Stages
    |--------------------------------------------------------------------------
    |
    | Here are all of the file stages that are available for a user to pick
    | from. They are used to signify the "stage" of each individual file
    | so any user can easily see the distance a plugin has progressed.
    |
    */

    'file_stages' => [
        'alpha',
        'beta',
        'release',
    ],

];
