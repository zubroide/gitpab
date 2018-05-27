<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributorTable extends Migration
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
            Schema::create('contributor', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->string('name');
                $table->string('username');
                $table->string('state');
                $table->text('avatar_url')->nullable();
                $table->string('web_url');
                $table->timestamps();
            });

            DB::statement('CREATE INDEX ON contributor (LOWER(name));');
            DB::statement('CREATE INDEX ON contributor (LOWER(username));');
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
        Schema::dropIfExists('contributor');
    }
}
