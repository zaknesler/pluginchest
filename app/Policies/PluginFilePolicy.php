<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PluginFile;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginFilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the plugin file.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PluginFile  $pluginFile
     * @return mixed
     */
    public function delete(User $user, PluginFile $pluginFile)
    {
        return $pluginFile->plugin->hasUserWithRole($user, 'owner');
    }
}
