<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSpentTableAddSpentAtColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        try {
            Schema::table('spent', function (Blueprint $table) {
                $table->timestamp('spent_at')->nullable()->index();
            });

            DB::statement('
                UPDATE spent AS s
                SET spent_at = n.gitlab_created_at 
                FROM note AS n
                WHERE n.id = s.note_id
            ');

            DB::statement('ALTER TABLE spent ALTER spent_at SET NOT NULL');

            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spent', function (Blueprint $table)
        {
            $table->dropColumn('spent_at');
        });
    }
}
