<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getRombelDescription;');
        
        DB::unprepared('
            CREATE FUNCTION getRombelDescription (kode CHAR(5))
            RETURNS VARCHAR(10)
            DETERMINISTIC
            BEGIN
                DECLARE keterangan VARCHAR(10);

                IF kode = "SijaA" THEN
                    SET keterangan = "SIJA A";
                ELSEIF kode = "SijaB" THEN
                    SET keterangan = "SIJA B";
                ELSE
                    SET keterangan = "Tidak diketahui";
                END IF;

                RETURN keterangan;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getRombelDescription;');
    }
};
