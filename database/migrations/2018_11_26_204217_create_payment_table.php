<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        DB::beginTransaction();
        try {
            Schema::create('payment_status', function (Blueprint $table) {
                $table->increments('id');
                $table->string('alias')->unique();
                $table->string('title')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });

            Schema::create('payment', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->decimal('hours');
                $table->integer('status_id');
                $table->foreign('status_id')
                    ->references('id')
                    ->on('payment_status')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->timestamp('payment_date');
                $table->integer('user_id')->index();
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
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
        Schema::dropIfExists('payment');
        Schema::dropIfExists('payment_status');
    }
}
