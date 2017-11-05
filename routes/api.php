<?php

Route::get('/packs', function () {
    $s3 = Storage::cloud();

    $packs = collect($s3->allFiles())
        ->filter(function ($name) {
            return ends_with($name, '/gamepack.jar');
        })->map(function ($name) {
            $rev = (int) collect(explode('/', $name))->first();
            $url = route('pack', compact('rev'));
            return compact('rev', 'url');
        })->values();
    return response()->json($packs);
});

Route::get('/deobs', function () {
    $s3 = Storage::disk('deobs');

    $deobs = collect($s3->allFiles())
        ->filter(function ($name) {
            return starts_with($name, 'runelite/');
        })->map(function ($name) {
            $rev = (int) explode('.', collect(explode('/', $name))->last())[0];
            $url = route('runelite', compact('rev'));
            return compact('rev', 'url');
        })->values();
    return response()->json($deobs);
});
