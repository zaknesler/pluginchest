<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plugin;
use Illuminate\Database\Eloquent\Model;

class PluginFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'approved_at',
        'downloads_count',
        'file_path',
        'file_size',
        'game_version',
        'stage',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved_at' => 'timestamp',
    ];

    /**
     * Scope a query to only include plugin files that have a path.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasFile($query)
    {
        return $query->whereNotNull('file_path');
    }

    /**
     * Get the file size with units.
     *
     * @return integer
     */
    public function getFileSize()
    {
        $fileSize = $this->file_size / 1024;

        if ($fileSize > 1024) {
            return number_format($fileSize / 1024, 1) . ' MB';
        }

        return number_format($fileSize, 1) . ' KB';
    }

    /**
     * A plugin file belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
