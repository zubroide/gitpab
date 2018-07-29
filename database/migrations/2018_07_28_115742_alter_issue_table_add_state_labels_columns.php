<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIssueTableAddStateLabelsColumns extends Migration
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
            Schema::table('issue', function (Blueprint $table) {
                $table->string('state')->nullable()->index();
            });
            DB::statement('ALTER TABLE issue ADD COLUMN labels character varying[] NULL');
	        DB::statement('CREATE INDEX issue_labels_index ON issue USING GIN (labels)');

            Schema::create('label', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });

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
        DB::beginTransaction();
        try {
            Schema::table('issue', function (Blueprint $table)
            {
                $table->dropColumn('labels');
                $table->dropColumn('state');
            });
            Schema::dropIfExists('label');
            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
