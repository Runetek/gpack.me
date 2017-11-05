<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Cache\Repository;

class Deobs extends ArtifactRepository
{
    function __construct()
    {
        parent::__construct(Storage::disk('deobs'));
    }

    function routeKey()
    {
        return 'runelite';
    }

    function getCacheKey()
    {
        return 'deobs';
    }

    function isArtifact($file)
    {
        return starts_with($file, 'runelite/') && ends_with($file, '.jar');
    }

    function formatFile($rev)
    {
        return sprintf('runelite/%s.jar', $rev);
    }

    function extractRevision($file)
    {
        return (int) explode('.', collect(explode('/', $file))->last())[0];
    }
}
