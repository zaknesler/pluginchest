<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Plugin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the plugin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function view(?User $user, Plugin $plugin)
    {
        return true;
    }

    /**
     * Determine whether the user can create plugins.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the plugin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function update(User $user, Plugin $plugin)
    {
        return $plugin->users()
                      ->whereIn('role', ['owner', 'author'])
                      ->where('user_id', $user->id)
                      ->count();
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
        return $plugin->users()
                      ->where('role', 'owner')
                      ->where('user_id', $user->id)
                      ->count();
    }

    /**
     * Determine whether the user can restore the plugin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function restore(User $user, Plugin $plugin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the plugin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plugin  $plugin
     * @return mixed
     */
    public function forceDelete(User $user, Plugin $plugin)
    {
        //
    }
}
