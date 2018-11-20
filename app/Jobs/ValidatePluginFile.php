<?php

namespace App\Jobs;

use ZipArchive;
use App\Models\PluginFile;
use App\Jobs\StorePluginFile;
use Illuminate\Bus\Queueable;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ValidatePluginFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Plugin file model.
     *
     * @var App\Models\PluginFile
     */
    protected $file;

    /**
     * List of validation errors discovered.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $errors;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PluginFile $file)
    {
        $this->file = $file;

        $this->errors = collect();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $unzipped = $this->unzip();
        $contents = $this->getYamlContents($unzipped);

        $this->checkYamlEntries($contents);
        $this->checkMainClassExists($unzipped, $contents);

        $this->file->update([
            'validation_errors' => $this->errors->isEmpty() ? null : $this->errors->toJson(),
            'validated_at' => $this->errors->isEmpty() ? now() : null,
        ]);
    }

    /**
     * Get the full path to the directory of the plugin file.
     *
     * @return string
     */
    private function getWorkingDirectory()
    {
        return Storage::disk(config('pluginchest.storage.temporary'))
                      ->path($this->file->temporary_file);
    }

    /**
     * Get the full path to the plugin file.
     *
     * @return string
     */
    private function getFileFullPath()
    {
        return join(DIRECTORY_SEPARATOR, [$this->getWorkingDirectory(), $this->file->temporary_file]);
    }

    /**
     * Unzip the .jar file.
     *
     * @return string
     */
    private function unzip()
    {
        $extractTo = join(DIRECTORY_SEPARATOR, [$this->getWorkingDirectory(), 'unzip']);

        $zip = new ZipArchive;
        $zip->open($this->getFileFullPath());
        $zip->extractTo($extractTo);
        $zip->close();

        return $extractTo;
    }

    /**
     * Retrieve the contents of the plugin.yml file.
     *
     * @param  string $unzipped
     * @return \Illuminate\Support\Collection
     */
    private function getYamlContents($unzipped)
    {
        $yamlFile = join(DIRECTORY_SEPARATOR, [$unzipped, 'plugin.yml']);

        if (!file_exists($yamlFile)) {
            $this->errors->push('No plugin.yml found.');

            return;
        }

        return collect(Yaml::parseFile($yamlFile));
    }

    /**
     * Check that the plugin.yml file has the correct entries
     *
     * @param  \Illuminate\Support\Collection $contents
     * @return void
     */
    private function checkYamlEntries($contents)
    {
        if (!$contents->has(['name', 'version', 'main'])) {
            $this->errors->push('Invalid plugin.yml file structure.');
        }

        $contents->each(function ($key, $value) {
            if (empty($value)) {
                $this->errors->push("Invalid plugin.yml: $key is null");
            }
        });
    }

    /**
     * Check that the main class defined in the plugin.yml file actually exists in the plugin file.
     *
     * @param  array $unzipped
     * @param  \Illuminate\Support\Collection $contents
     * @return void
     */
    public function checkMainClassExists($unzipped, $contents)
    {
        $mainPath = join(DIRECTORY_SEPARATOR, collect($unzipped)
                  ->merge(explode('.', $contents->get('main')))
                  ->toArray());

        if (!file_exists($mainPath . '.class')) {
            $this->errors->push("The main class defined in plugin.yml could not be located.");
        }
    }
}
