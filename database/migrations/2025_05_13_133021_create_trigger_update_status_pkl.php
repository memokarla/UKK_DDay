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
        // Trigger ketika data PKL ditambahkan
        DB::unprepared("
            CREATE TRIGGER update_status_lapor_pkl
            AFTER INSERT ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas SET status_lapor_pkl = TRUE WHERE id = NEW.siswa_id;
            END
        ");

        // Trigger ketika data PKL dihapus
        DB::unprepared("
            CREATE TRIGGER revert_status_lapor_pkl
            AFTER DELETE ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas SET status_lapor_pkl = FALSE WHERE id = OLD.siswa_id;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER update_status_lapor_pkl_on_update
            AFTER UPDATE ON pkls
            FOR EACH ROW
            BEGIN
                IF OLD.siswa_id != NEW.siswa_id THEN
                    IF (SELECT COUNT(*) FROM pkls WHERE siswa_id = OLD.siswa_id AND id != OLD.id) = 0 THEN
                        UPDATE siswas SET status_lapor_pkl = FALSE WHERE id = OLD.siswa_id;
                    END IF;
                    UPDATE siswas SET status_lapor_pkl = TRUE WHERE id = NEW.siswa_id;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_status_lapor_pkl');
        DB::unprepared('DROP TRIGGER IF EXISTS revert_status_lapor_pkl');
        DB::unprepared('DROP TRIGGER IF EXISTS update_status_lapor_pkl_on_update');
    }
};
