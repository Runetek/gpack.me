<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\MediaLibrary\Media;

class ExtractJarBuildTime //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const JAR_MANIFEST = 'META-INF/MANIFEST.MF';

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

        $manifest_timestamp = array_get($zip->statName(self::JAR_MANIFEST), 'mtime');

        $this->media->setCustomProperty('built_at', (int) $manifest_timestamp);
        $this->media->saveOrFail();

        $zip->close();
    }
}
