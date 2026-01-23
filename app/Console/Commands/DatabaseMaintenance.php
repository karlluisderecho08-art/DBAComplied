<?php

// app/Console/Commands/DatabaseMaintenance.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseMaintenance extends Command
{
    protected $signature = 'app:db-maintenance';
    protected $description = 'Perform database maintenance tasks (optimize, clean logs)';

    public function handle()
    {
        $this->info('Starting Database Maintenance...');

        // 1. Application Level: Clean old password reset tokens (older than 3 days)
        $deleted = DB::table('password_reset_tokens')
            ->where('created_at', '<', now()->subDays(3))
            ->delete();
        $this->info("Cleaned $deleted old password tokens.");

        // 2. Database Level: Optimize Tables (MySQL specific)
        // This reclaims unused space and defragments data files
        $tables = ['bookings', 'rooms', 'users', 'booking_audits'];
        
        foreach ($tables as $table) {
            $this->info("Optimizing table: $table");
            DB::statement("OPTIMIZE TABLE $table");
        }

        $this->info('Maintenance complete successfully.');
    }
}

//for maintenance