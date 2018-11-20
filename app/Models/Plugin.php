<?php

namespace App\Models;

use App\Models\PluginFile;
use App\Models\Pivots\PluginUser;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'published_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'timestamp',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total_downloads_count',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($plugin) {
            $plugin->slug = str_slug($plugin->name);
        });
    }

    /**
     * Get the URL to view a plugin.
     *
     * @return string
     */
    public function getUrl()
    {
        return route('plugins.show', [$this->slug, $this->id]);
    }

    /**
     * Get the plugin's total downloads by adding downloads for each file.
     *
     * @return string
     */
    public function getTotalDownloadsCountAttribute()
    {
        return $this->files->sum('downloads_count');
    }

    /**
     * Scope a query to only include published plugins.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * A plugin belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(PluginUser::class)
            ->withPivot('role');
    }

    /**
     * A plugin has many plugin files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(PluginFile::class);
    }
}
