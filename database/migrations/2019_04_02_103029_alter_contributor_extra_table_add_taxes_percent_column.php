<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContributorExtraTableAddTaxesPercentColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributor_extra', function (Blueprint $table) {
            $table->decimal('taxes_percent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributor_extra', function (Blueprint $table)
        {
            $table->dropColumn('taxes_percent');
        });
    }
}
