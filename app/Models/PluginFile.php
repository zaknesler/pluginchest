<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plugin;
use App\Jobs\StorePluginFile;
use App\Jobs\ValidatePluginFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PluginFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plugin_id',
        'user_id',
        'name',
        'description',
        'validation_errors',
        'validated_at',
        'approved_at',
        'downloads_count',
        'temporary_file',
        'file_name',
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
        return $query->whereNotNull('file_name');
    }

    /**
     * Temporarily store file and dispatch jobs to validate and store it.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return null
     */
    public function store(UploadedFile $file)
    {
        $name = str_random(8);

        $file->storeAs($name, $name, config('pluginchest.storage.temporary'));
        $this->update(['temporary_file' => $name]);

        ValidatePluginFile::dispatch($this)->chain([
            new StorePluginFile($this),
        ]);
    }

    /**
     * Get the file size with units.
     *
     * @return string
     */
    public function getFileSize()
    {
        $value = $this->file_size / 1024;

        if ($value > 1024) {
            return number_format($value / 1024, 1) . ' MB';
        }

        return number_format($value, 1) . ' KB';
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
