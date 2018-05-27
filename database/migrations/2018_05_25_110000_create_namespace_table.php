<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNamespaceTable extends Migration
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
            Schema::create('namespace', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->string('name');
                $table->string('path');
                $table->string('kind');
                $table->string('full_path');
                $table->bigInteger('parent_id')->nullable();
                $table->timestamps();
            });

            DB::statement('CREATE INDEX ON contributor (LOWER(name));');
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
        Schema::dropIfExists('namespace');
    }
}
