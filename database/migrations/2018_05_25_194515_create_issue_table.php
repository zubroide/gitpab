<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTable extends Migration
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
            Schema::create('issue', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->integer('iid');
                $table->bigInteger('project_id')->index();
                $table->foreign('project_id')
                    ->references('id')
                    ->on('project')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->bigInteger('author_id')->index();
                $table->foreign('author_id')
                    ->references('id')
                    ->on('contributor')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->bigInteger('assignee_id')->index()->nullable();
                $table->foreign('assignee_id')
                    ->references('id')
                    ->on('contributor')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->timestamp('gitlab_created_at')->nullable();
                $table->timestamp('gitlab_updated_at')->nullable();
                $table->string('web_url');
                $table->timestamps();
            });

            DB::statement('CREATE INDEX ON issue (LOWER(title));');
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
        Schema::dropIfExists('issue');
    }
}
