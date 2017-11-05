<?php

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

Route::get('/07/{rev}', function ($rev) {
    $s3 = Storage::cloud();
    $filename = sprintf('%s/gamepack.jar', $rev);

    abort_unless(collect($s3->allFiles())->contains($filename), 404, 'Not found');

    return redirect($s3->url($filename));
})->name('pack');

Route::get('/rl/{rev}', function (App\Deobs $deobs, $rev) {
    $deob = $deobs->find($rev);

    abort_unless($deob, 404);

    return redirect($s3->url($filename));
})->name('runelite');
