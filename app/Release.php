<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

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

    public function getRouteKeyName()
    {
        return 'revision';
    }
}
