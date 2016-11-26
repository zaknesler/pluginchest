<?php

namespace App\Policies;

use App\User;
use App\Plugin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the plugin.
     *
     * @param  App\User  $user
     * @param  App\Plugin  $plugin
     * @return mixed
     */
    public function view(User $user, Plugin $plugin)
    {
        return true;
    }

    /**
     * Determine whether the user can create plugins.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the plugin.
     *
     * @param  App\User  $user
     * @param  App\Plugin  $plugin
     * @return mixed
     */
    public function update(User $user, Plugin $plugin)
    {
        return $user->id == $plugin->user_id;
    }

    /**
     * Determine whether the user can delete the plugin.
     *
     * @param  App\User  $user
     * @param  App\Plugin  $plugin
     * @return mixed
     */
    public function delete(User $user, Plugin $plugin)
    {
        return $user->id == $plugin->user_id;
    }

    /**
     * Determine whether the user can create files for a plugin.
     *
     * @param  App\User  $user
     * @param  App\Plugin  $plugin
     * @return mixed
     */
    public function createPluginFile(User $user, Plugin $plugin)
    {
        return $user->id == $plugin->user_id;
    }
}
