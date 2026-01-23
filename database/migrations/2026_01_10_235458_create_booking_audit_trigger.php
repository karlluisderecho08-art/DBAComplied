<?php

// database/migrations/xxxx_xx_xx_create_booking_audit_trigger.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the Audit Table
        Schema::create('booking_audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->string('action'); // UPDATE, DELETE
            $table->timestamp('changed_at')->useCurrent();
        });

        // 2. Create the Trigger
        $trigger = "
        CREATE TRIGGER tr_booking_update_audit
        AFTER UPDATE ON bookings
        FOR EACH ROW
        BEGIN
            -- Only log if status changed
            IF OLD.status <> NEW.status THEN
                INSERT INTO booking_audits (booking_id, old_status, new_status, action, changed_at)
                VALUES (OLD.id, OLD.status, NEW.status, 'STATUS_CHANGE', NOW());
            END IF;
        END;
        ";

        DB::unprepared("DROP TRIGGER IF EXISTS tr_booking_update_audit");
        DB::unprepared($trigger);
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS tr_booking_update_audit");
        Schema::dropIfExists('booking_audits');
    }
};


//for auditing