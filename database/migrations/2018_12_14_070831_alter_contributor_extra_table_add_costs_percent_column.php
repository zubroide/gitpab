<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContributorExtraTableAddCostsPercentColumn extends Migration
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
            Schema::table('contributor_extra', function (Blueprint $table) {
                $table->decimal('costs_percent')->default(0);
            });
            Schema::table('payment', function (Blueprint $table) {
                $table->decimal('costs_percent')->default(0);
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
            Schema::table('payment', function (Blueprint $table)
            {
                $table->dropColumn('costs_percent');
            });
            Schema::table('contributor_extra', function (Blueprint $table)
            {
                $table->dropColumn('costs_percent');
            });

            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

}
