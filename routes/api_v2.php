<?php

use App\Reports\ReportFetcher;
use App\Http\Resources\Report as ReportResource;
use App\Http\Resources\Pack as PackResource;
use App\Report;
use App\Gamepacks;
use Illuminate\Pagination\LengthAwarePaginator;

Route::get('packs', function (Gamepacks $gamepacks) {
    $page = request('page', 1);
    $limit = 25;
    $packs = $gamepacks->all()->sortByDesc('rev');
    $items = $packs->forPage($page, $limit)->values();
    $paginated = new LengthAwarePaginator($items, count($packs), $limit, $page);
    $paginated->setPath(request()->url());

    return PackResource::collection($paginated);
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
