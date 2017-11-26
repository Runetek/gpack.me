<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\Media;

class Release extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = [];

    public $casts = [
        'revision' => 'int',
    ];

    function artifacts()
    {
        return $this->hasMany(Artifact::class);
    }

    public function gamepack()
    {
        return $this->morphOne(config('medialibrary.media_model'), 'model')
                ->where('collection_name', '=', 'gamepacks');
    }

    public function deobs()
    {
        return $this->morphMany(config('medialibrary.media_model'), 'model')
                ->where('collection_name', '=', 'deobs');
    }

    public function runelite()
    {
        return $this->morphOne(config('medialibrary.media_model'), 'model')
            ->where('collection_name', '=', 'gamepacks')
            ->where('name', '=', 'runelite');
    }

    public function getRouteKeyName()
    {
        return 'revision';
    }
}
