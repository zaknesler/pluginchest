<?php

namespace App\Policies;

use App\User;
use App\Plugin;
use App\PluginFile;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginFilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the plugin file.
     *
     * @param  App\User  $user
     * @param  App\PluginFile  $pluginFile
     * @return mixed
     */
    public function view(User $user, PluginFile $pluginFile)
    {
        return true;
    }

    /**
     * Determine whether the user can update the plugin file.
     *
     * @param  App\User  $user
     * @param  App\PluginFile  $pluginFile
     * @return mixed
     */
    public function update(User $user, PluginFile $pluginFile)
    {
        return $user->id == $pluginFile->user_id;
    }

    /**
     * Determine whether the user can delete the plugin file.
     *
     * @param  App\User  $user
     * @param  App\PluginFile  $pluginFile
     * @return mixed
     */
    public function delete(User $user, PluginFile $pluginFile)
    {
        return $user->id == $pluginFile->user_id;
    }
}
