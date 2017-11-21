<?php

use App\Reports\ReportFetcher;
use App\Http\Resources\Report as ReportResource;
use App\Report;

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
