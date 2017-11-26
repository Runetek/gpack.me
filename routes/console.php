<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Reports\ReportFetcher;
use App\ReportType;
use App\Report;
use App\Release;
use App\Artifact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('import:gamepacks', function () {
    Release::all()->each(function ($release) {
        try {
            DB::transaction(function () use ($release) {
                $remote_file = $release->revision . '/gamepack.jar';

                // if (!Storage::cloud()->exists($remote_file)) {
                //     return;
                // }

                $artifact = new Artifact([
                    'release_id' => $release->id,
                ]);
                $artifact->save();

                $this->info($remote_file.' '.$release->revision);

                Storage::put('tmp.jar', Storage::cloud()->get($remote_file));

                $artifact->addMediaFromUrl(Storage::cloud()->url($remote_file))
                        ->usingFileName($release->revision.'-gamepack.jar')
                        ->withCustomProperties([
                            'checksums' => [
                                'md5' => md5_file(storage_path('app/tmp.jar')),
                                'sha1' => sha1_file(storage_path('app/tmp.jar')),
                            ],
                        ])
                        ->toMediaCollection('gamepacks');
            });
        } catch (Exception $e) {
            $this->error('Error: '.$e->getMessage());
        }
    });
});

Artisan::command('fetch-reports', function (ReportFetcher $reports) {
    $items = $reports->all();

    $existingReportTypes = ReportType::all()->pluck('fqcn');

    $reports->availableReportTypes()
        ->diff($existingReportTypes->values())
        ->each(function ($fqcn) {
            ReportType::create(compact('fqcn'));
        });

    $reportTypes = ReportType::all()->pluck('id', 'fqcn');
    $reportTypes->dump();

    $items->each(function ($report) use ($reportTypes) {
        Report::create([
            'report_type_id' => $reportTypes[$report['fqcn']],
            'revision' => $report['revision'],
        ]);
    });
});
