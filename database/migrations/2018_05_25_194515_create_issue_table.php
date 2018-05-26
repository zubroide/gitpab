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
                $table->bigInteger('project_id');
                $table->foreign('project_id')->references('id')->on('project')->onDelete('CASCADE');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->bigInteger('author_id');
                $table->bigInteger('assignee_id')->nullable();
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
