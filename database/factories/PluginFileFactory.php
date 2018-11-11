<?php

use App\Models\User;
use App\Models\Plugin;
use Faker\Generator as Faker;

$factory->define(App\Models\PluginFile::class, function (Faker $faker) {
    return [
        'plugin_id' => function () {
            return factory(Plugin::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => 'Fake Plugin File',
        'description' => 'This is a fake plugin file.',
        'validated_at' => now()->subDays(2),
        'approved_at' => now()->subDays(1),
        'downloads_count' => 0,
        'temporary_file' => null,
        'file_name' => null,
        'file_size' => null,
        'game_version' => '1.12.2',
        'stage' => 'release',
    ];
});
