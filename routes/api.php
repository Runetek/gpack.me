<?php

Route::get('/packs', function (App\Gamepacks $gamepacks) {
    return response()->json($gamepacks->all()->map(function ($pack) {
        $rev = $pack['rev'];
        return ['rev' => $rev, 'url' => route('pack', compact('rev'))];
    }));
});

Route::get('/artifacts', function (App\Gamepacks $gamepacks, App\Deobs $deobs) {
    return $gamepacks->all()->pluck('rev')
        ->map(function ($rev) use ($gamepacks, $deobs) {
            $pack = $gamepacks->find($rev);
            $deob = $deobs->find($rev);
            return compact('pack', 'deob');
        })->keyBy('pack.rev');
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
    return response()->json($deobs->all()->map(function ($deob) {
        $rev = $deob['rev'];
        return ['rev' => $rev, 'url' => route('runelite', compact('rev'))];
    }));
});

Route::get('/deobs/{rev}', function (App\Deobs $deobs, $rev) {
    $pack = $deobs->find($rev);
    abort_unless($pack, 404);
    return response()->json($pack);
});
