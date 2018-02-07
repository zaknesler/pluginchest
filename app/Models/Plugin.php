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
            ->withPivot('is_creator');
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
