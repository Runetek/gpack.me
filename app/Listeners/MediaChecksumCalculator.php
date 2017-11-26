<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\MediaLibrary\Events\MediaHasBeenAdded;

class MediaChecksumCalculator implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  MediaHasBeenAdded  $event
     * @return void
     */
    public function handle(MediaHasBeenAdded $event)
    {
        $media = $event->media;
        if ($media->collection_name === 'gamepacks') {
            $media->setCustomProperty('checksums', [
                'md5' => md5_file($media->getPath()),
                'sha1' => sha1_file($media->getPath()),
            ]);
            $media->save();
        }
    }
}
