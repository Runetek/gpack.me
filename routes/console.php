<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Reports\ReportFetcher;
use App\ReportType;
use App\Report;

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
