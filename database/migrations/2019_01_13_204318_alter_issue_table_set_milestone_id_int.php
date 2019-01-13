<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterIssueTableSetMilestoneIdInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE issue ALTER COLUMN milestone_id TYPE bigint USING milestone_id::bigint');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE issue ALTER COLUMN milestone_id TYPE varchar(255)');
    }
}
