<?php

use App\Reports\ReportFetcher;
use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\Report as ReportResource;
use App\Artifact;
use App\Report;

Route::get('packs', function () {
    return ArtifactResource::collection(
        Artifact::with('media', 'release')
            ->latest()
            ->paginate(25)
    );
})->name('api.v2.packs');

Route::get('reports', function () {
    return ReportResource::collection(
        Report::with('reportType')
            ->orderBy('revision', 'desc')
            ->paginate(25)
    );
})->name('reports');

Route::get('reports/{revision}', function ($revision) {
    return ReportResource::collection(
        Report::with('reportType')
            ->where('revision', '=', $revision)
            ->paginate(25)
    );
});

Route::get('search_index', function (ReportFetcher $reports) {
    return [
        'revisions' => $reports->availableRevisions(),
        'reportTypes' => $reports->availableReportTypes(),
    ];
});
