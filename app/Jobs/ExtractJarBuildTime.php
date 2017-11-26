<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\MediaLibrary\Media;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ExtractJarBuildTime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Media */
    private $media;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new \ZipArchive();
        if ($zip->open($this->media->getPath(), 0) !== true) {
            throw new \Exception('Unable to open zip '.$this->media->getPath());
        }

        $zipStats = collect(range(0, $zip->numFiles - 1))
            ->map(function ($index) use ($zip) {
                return $zip->statIndex($index);
            });

        $numClasses = $zipStats->pluck('name')
                ->filter(function ($name) {
                    return Str::endsWith($name, '.class');
                })->count();

        $this->media->setCustomProperty('built_at', $zipStats->max('mtime'));
        $this->media->setCustomProperty('num_classes', $numClasses);
        $this->media->saveOrFail();

        $zip->close();
    }
}
