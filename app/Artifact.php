<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Ramsey\Uuid\Uuid;

class Artifact extends Model implements HasMedia
{
    use HasMediaTrait;

    public $incrementing = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Uuid::uuid4()->toString();
            }

            return true;
        });
    }

    function release()
    {
        return $this->belongsTo(Release::class);
    }
}
