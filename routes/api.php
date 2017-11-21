<?php

use App\Reports\ReportFetcher;

Route::get('reports', function (ReportFetcher $reports) {
    return $reports->all();
});

Route::get('search_index', function (ReportFetcher $reports) {
    return [
        'revisions' => $reports->availableRevisions(),
        'reportTypes' => $reports->availableReportTypes(),
    ];
});

Route::get('/packs', function (App\Gamepacks $gamepacks) {
    return response()->json($gamepacks->all()->map(function ($pack) use ($gamepacks) {
        $rev = $pack['rev'];
        return ['rev' => $rev, 'url' => $gamepacks->url($rev)];
    }));
});

Route::get('/artifacts', function (App\Gamepacks $gamepacks, App\Deobs $deobs) {
    return $gamepacks->all()->pluck('rev')
        ->map(function ($rev) use ($gamepacks, $deobs) {
            $pack = $gamepacks->find($rev);
            $deob = $deobs->find($rev);
            return compact('rev', 'pack', 'deob');
        })->values();
});

Route::get('/artifacts/{rev}', function ($rev, App\Gamepacks $gamepacks, App\Deobs $deobs) {
    $deob = $deobs->find($rev);
    $pack = $gamepacks->find($rev);

    return response()->json(compact('pack', 'deob'));
});

Route::get('/packs/{rev}', function (App\Gamepacks $gamepacks, $rev) {
    $pack = $gamepacks->find($rev);
    abort_unless($pack, 404);
    return response()->json($pack);
});

Route::get('/deobs', function (App\Deobs $deobs) {
    return response()->json($deobs->all()->map(function ($deob) use ($deobs) {
        $rev = $deob['rev'];
        return ['rev' => $rev, 'url' => $deobs->url($rev)];
    }));
});

Route::get('/deobs/{rev}', function (App\Deobs $deobs, $rev) {
    $pack = $deobs->find($rev);
    abort_unless($pack, 404);
    return response()->json($pack);
});
