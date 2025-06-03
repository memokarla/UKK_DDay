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
        DB::unprepared('DROP FUNCTION IF EXISTS getGenderDescription;');
        
        DB::unprepared('
            CREATE FUNCTION getGenderDescription (kode CHAR(1))
            RETURNS VARCHAR(20)
            DETERMINISTIC
            BEGIN
                DECLARE keterangan VARCHAR(20);

                IF kode = "L" THEN
                    SET keterangan = "Laki-Laki";
                ELSEIF kode = "P" THEN
                    SET keterangan = "Perempuan";
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
        DB::unprepared('DROP FUNCTION IF EXISTS getGenderDescription;');
    }
};
