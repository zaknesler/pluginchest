<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Plugin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the plugin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function update(User $user, Plugin $plugin)
    {
        return $plugin->hasUserWithRole($user, ['owner', 'author']);
    }

    /**
     * Determine whether the user can delete the plugin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function delete(User $user, Plugin $plugin)
    {
        return $plugin->hasUserWithRole($user, 'owner');
    }

    /**
     * Determine whether the user can create a plugin file.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function createPluginFile(User $user, Plugin $plugin)
    {
        return $plugin->hasUserWithRole($user, ['owner', 'author']);
    }
}
