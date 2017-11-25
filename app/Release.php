<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $guarded = [];

    function artifacts()
    {
        return $this->hasMany(Artifact::class);
    }

    public function getRouteKeyName()
    {
        return 'revision';
    }
}
