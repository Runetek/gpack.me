<?php

use App\Release;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('packs', function () {
    return view('packs.index');
});

Route::get('/07/{rev}', function (App\Gamepacks $gamepacks, $rev) {
    $pack = $gamepacks->find($rev);

    abort_unless($pack, 404);

    return redirect($gamepacks->url($rev));
})->name('pack');

Route::get('/rl/{rev}', function (App\Deobs $deobs, $rev) {
    $deob = $deobs->find($rev);

    abort_unless($deob, 404);

    return redirect($deobs->url($rev));
})->name('runelite');

Route::group(['subdomain' => 'get.gpack.me'], function () {
    Route::get('{release}', function (Release $release) {
        return $release->artifacts->first()->getMedia();
    });
});
