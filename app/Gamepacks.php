<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Cache\Repository;

class Gamepacks extends ArtifactRepository
{
    function __construct()
    {
        parent::__construct(Storage::cloud());
    }

    function getCacheKey()
    {
        return 'gamepacks';
    }

    function isArtifact($file)
    {
        return ends_with($file, '/gamepack.jar');
    }

    function formatFile($rev)
    {
        return sprintf('%s/gamepack.jar', $rev);
    }

    function extractRevision($file)
    {
        return (int) collect(explode('/', $file))->first();
    }
}
