<?php

namespace App;

use App\Plugin;
use App\PluginFile;
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
        'username',
        'email',
        'avatar',
        'password',
        'last_login_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login_at',
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
     * If the user has a name set, return it; otherwise, return the username.
     *
     * @return mixed
     */
    public function getNameOrUsername()
    {
        if (!$this->name) {
            return $this->username;
        }

        return $this->name;
    }

    /**
     * Get the path to the user's avatar. Use Gravatar as a fall-back.
     *
     * @param  integer  $size
     * @return string
     */
    public function getAvatar(int $size = 100)
    {
        if (!$this->avatar) {
            return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '?s=' . $size . '&d=mm';
        }

        return 'https://ucarecdn.com/' . $this->avatar . '/-/scale_crop/1024x1024/center/-/quality/lighter/-/progressive/yes/-/resize/' . $size . '/';
    }

    /**
     * A user has many plugins.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plugins()
    {
        return $this->hasMany(Plugin::class);
    }

    /**
     * A user has many plugin files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pluginFiles()
    {
        return $this->hasMany(PluginFile::class);
    }
}
