<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReportType;

class Report extends Model
{
    protected $guarded = [];

    function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }
}
