<?php

namespace App;

use Storage;
use App\Plugin;
use Illuminate\Database\Eloquent\Model;

class PluginFile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plugins_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'summary',
        'downloads_count',
        'file',
        'game_version',
        'stage',
        'approved_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'approved_at',
    ];

    /**
     * Scope a query to only include plugin files that have a value in the 'file' column.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasFile($query)
    {
        return $query->whereNotNull('file');
    }

    /**
     * A plugin file belongs to a plugin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plugin()
    {
        return $this->belongsTo(Plugin::class);
    }
}
