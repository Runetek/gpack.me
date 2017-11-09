<?php

namespace App;

use Illuminate\Support\Facades\Storage;

abstract class ArtifactRepository
{
    private $s3;

    function __construct($s3)
    {
        $this->s3 = $s3;
    }

    abstract function getCacheKey();

    abstract function isArtifact($file);

    abstract function extractRevision($file);

    abstract function formatFile($rev);

    abstract function routeKey();

    function all()
    {
        return cache()->remember($this->getCacheKey(), 10, function () {
            return collect($this->s3->allFiles())
                ->filter(function ($name) {
                    return $this->isArtifact($name);
                })->map(function ($name) {
                    $rev = $this->extractRevision($name);
                    $url = $this->url($rev);
                    return compact('rev', 'name', 'url');
                })->values();
        });
    }

    function find($rev)
    {
        return $this->all()->where('rev', '=', $rev)->first();
    }

    function url($rev)
    {
        return $this->s3->url($this->formatFile($rev));
    }
}
