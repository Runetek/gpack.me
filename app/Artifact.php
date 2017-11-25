<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Artifact extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = [];

    function release()
    {
        return $this->belongsTo(Release::class);
    }
}
