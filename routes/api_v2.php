<?php

use App\Reports\ReportFetcher;
use App\Http\Resources\Release as ReleaseResource;
use App\Http\Resources\Report as ReportResource;
use App\Report;
use App\Release;

Route::get('packs', function () {
    return ReleaseResource::collection(
        Release::has('gamepack')
            ->with('gamepack')
            ->orderByDesc('revision')
            ->paginate()
    );
})->name('api.v2.packs');

Route::get('packs/{revision}', function (Release $revision) {
    $revision->load('gamepack');
    $revision->gamepack ?? abort(404);
    return ReleaseResource::make($revision);
})->name('api.v2.pack');

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
