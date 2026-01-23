<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:backup', function () {
    $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
    $command = "mysqldump --user=" . env('DB_USERNAME') . 
               " --password=" . env('DB_PASSWORD') . 
               " --host=" . env('DB_HOST') . 
               " " . env('DB_DATABASE') . " > " . storage_path('app/' . $filename);
    
    exec($command);
    
    $this->info('Backup created: ' . $filename);
})->purpose('Backup the database');

//for recovery