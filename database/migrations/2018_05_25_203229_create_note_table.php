<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTable extends Migration
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
            Schema::create('note', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->bigInteger('issue_id')->index();
                $table->foreign('issue_id')
                    ->references('id')
                    ->on('issue')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->text('body')->nullable();
                $table->bigInteger('author_id')->index();
                $table->foreign('author_id')
                    ->references('id')
                    ->on('contributor')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->timestamp('gitlab_created_at', 3)->nullable();
                $table->timestamp('gitlab_updated_at', 3)->nullable();
                $table->timestamps();
            });

            DB::statement('CREATE INDEX ON note (LOWER(body));');
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
        Schema::dropIfExists('note');
    }
}
