<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaymentTableAddAmountAndHourRateColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->decimal('amount')->nullable();
            $table->decimal('hour_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment', function (Blueprint $table)
        {
            $table->dropColumn('amount');
            $table->dropColumn('hour_rate');
        });
    }
}
