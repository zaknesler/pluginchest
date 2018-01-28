<?php

namespace App\Models;

use App\Models\Plugin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * A user has many plugins.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plugins()
    {
        return $this->hasMany(Plugin::class);
    }
}
