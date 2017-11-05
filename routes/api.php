<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/deobs', function () {
    $s3 = Storage::disk('deobs');

    $deobs = collect($s3->allFiles())
        ->filter(function ($name) {
            return starts_with($name, 'runelite/');
        })->map(function ($name) {
            $rev = collect(explode('/', $name))->last();
            return route('runelite', compact('rev'));
        });
    return response()->json($deobs);
});
