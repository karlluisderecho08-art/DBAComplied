<?php

// database/migrations/xxxx_xx_xx_create_booking_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $procedure = "
        DROP PROCEDURE IF EXISTS sp_create_booking;
        
        CREATE PROCEDURE sp_create_booking(
            IN p_user_id BIGINT,
            IN p_room_id BIGINT,
            IN p_check_in DATE,
            IN p_check_out DATE,
            IN p_guests INT,
            IN p_full_name VARCHAR(255),
            IN p_email VARCHAR(255),
            IN p_phone VARCHAR(255),
            IN p_payment_method VARCHAR(50),
            IN p_special_requests TEXT,
            IN p_total_amount DECIMAL(10,2),
            IN p_booking_id_str VARCHAR(255)
        )
        BEGIN
            DECLARE v_overlap_count INT;
            DECLARE v_room_capacity INT;
            
            DECLARE EXIT HANDLER FOR SQLEXCEPTION
            BEGIN
                ROLLBACK;
                RESIGNAL;
            END;

            START TRANSACTION;

            -- 1. Check for overlapping bookings for this room
            SELECT COUNT(*) INTO v_overlap_count
            FROM bookings
            WHERE room_id = p_room_id
            AND status != 'cancelled'
            AND (
                (check_in < p_check_out) AND (check_out > p_check_in)
            );

            -- 2. Get the room's total capacity (using available_rooms column as the limit per your Room.php)
            SELECT available_rooms INTO v_room_capacity 
            FROM rooms 
            WHERE id = p_room_id;

            -- 3. Compare Capacity vs Overlaps
            -- If we have 5 rooms and 2 overlaps, 5 > 2 is TRUE (Available)
            -- If we have 5 rooms and 5 overlaps, 5 > 5 is FALSE (Full)
            IF v_room_capacity > v_overlap_count THEN
               
                INSERT INTO bookings (
                    booking_id, user_id, room_id, check_in, check_out, 
                    guests, full_name, email, phone, payment_method, 
                    special_requests, total_amount, status, created_at, updated_at
                ) VALUES (
                    p_booking_id_str, p_user_id, p_room_id, p_check_in, p_check_out, 
                    p_guests, p_full_name, p_email, p_phone, p_payment_method, 
                    p_special_requests, p_total_amount, 'confirmed', NOW(), NOW()
                );
                
                COMMIT;
                SELECT 'Booking Successful' as result;
            ELSE
                ROLLBACK;
                -- This error message is what you saw in the browser
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Room not available for selected dates';
            END IF;
        END;
        ";

        DB::unprepared($procedure);
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_create_booking");
    }
};

//stored procedure for booking