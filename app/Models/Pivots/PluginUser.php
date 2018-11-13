<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PluginUser extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
    ];

    /**
     * Determine if a plugin's user has a specified role.
     *
     * @param  string  $role
     * @return boolean
     */
    public function hasRole($role)
    {
        return $this->role == $role;
    }
}
