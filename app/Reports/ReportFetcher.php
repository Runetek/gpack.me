<?php

namespace App\Reports;

use Illuminate\Contracts\Filesystem\Cloud;


class ReportFetcher
{
    private $s3;

    function __construct(Cloud $s3)
    {
        $this->s3 = $s3;
    }

    public function all()
    {
        return cache()->remember('reports', 1, function () {
            return $this->fresh();
        });
    }

    public function availableRevisions()
    {
        return $this->all()
            ->pluck('revision')
            ->unique()
            ->values();
    }

    public function availableReportTypes()
    {
        return $this->all()
            ->pluck('fqcn')
            ->unique()
            ->values();
    }

    public function fresh()
    {
        return collect($this->s3->allFiles())
            ->map(function ($file) {
                return $this->transformFile($file);
            });
    }

    private function transformFile($file)
    {
        $path = collect(explode('/', $file));
        \abort_if($path->count() !== 2, 400);

        $revision = (int) $path->first();
        $fqcn = collect(explode('.', $path->last()))
            ->slice(-1)
            ->implode('.');
        $url = $this->s3->url($file);
        return compact('revision', 'url', 'fqcn');
    }

    private function path($rev, $report)
    {
        return sprintf('%d/%s', $rev, $report);
    }
}
