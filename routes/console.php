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
use App\Jobs\ExtractJarBuildTime;
use App\Jobs\CalculateMediaChecksums;

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
    Release::doesntHave('gamepack')->get()->each(function ($release) {
        try {
            $remote_file = $release->revision . '/gamepack.jar';

            $this->info($remote_file.' '.$release->revision);

            $release->addMediaFromUrl(Storage::cloud()->url($remote_file))
                    ->usingFileName($release->revision.'-gamepack.jar')
                    ->toMediaCollection('gamepacks');
        } catch (Exception $e) {
            $this->error($e.' '.$e->getTraceAsString());
        }
    });
});

Artisan::command('import:runelite', function () {
    Release::doesntHave('runelite')->get()->each(function ($release) {
        try {
            $remote_file = sprintf('runelite/%d.jar', $release->revision);

            $this->info($remote_file.' '.$release->revision);

            $release->addMediaFromUrl(Storage::disk('deobs')->url($remote_file))
                    ->usingName('runelite')
                    ->usingFileName('runelite-'.$release->revision.'.jar')
                    ->toMediaCollection('deobs');
        } catch (Exception $e) {
            $this->error($e.' '.$e->getTraceAsString());
        }
    });
});

Artisan::command('spawn:calculate-checksums', function () {
    Release::has('gamepack')->get()->each(function (Release $release) {
        dispatch(new CalculateMediaChecksums($release->gamepack));
    });
});

Artisan::command('spawn:release-time', function () {
    Release::has('gamepack')->get()->each(function (Release $release) {
        dispatch(new ExtractJarBuildTime($release->gamepack));
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
