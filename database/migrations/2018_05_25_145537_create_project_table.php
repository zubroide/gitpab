<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
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
            Schema::create('project', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('path_with_namespace');
                $table->bigInteger('namespace_id');
                $table->string('web_url')->unique();
                $table->string('ssh_url_to_repo')->unique();
                $table->string('http_url_to_repo')->unique();
                $table->string('creator_id');
                $table->timestamps();
            });

            DB::statement('CREATE INDEX ON project (LOWER(name));');
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
        Schema::dropIfExists('project');
    }
}
