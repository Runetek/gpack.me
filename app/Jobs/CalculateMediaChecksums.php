<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\MediaLibrary\Media;

class CalculateMediaChecksums implements ShouldQueue
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
        $media = $this->media;
        $media->setCustomProperty('checksums', [
            'md5' => md5_file($media->getPath()),
            'sha1' => sha1_file($media->getPath()),
        ]);
        $media->save();
    }
}
