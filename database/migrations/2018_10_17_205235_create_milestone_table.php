<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestoneTable extends Migration
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
            Schema::create('milestone', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->integer('iid')->index();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('state');
                $table->timestamp('start_date')->nullable();
                $table->timestamp('due_date')->nullable();
                $table->bigInteger('project_id')->index()->nullable();
                $table->foreign('project_id')
                    ->references('id')
                    ->on('project')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->bigInteger('group_id')->index()->nullable();
                $table->foreign('group_id')
                    ->references('id')
                    ->on('namespace')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
                $table->timestamp('gitlab_created_at', 3)->nullable();
                $table->timestamp('gitlab_updated_at', 3)->nullable();
                $table->string('web_url');
                $table->timestamps();
            });

            Schema::table('issue', function (Blueprint $table) {
                $table->string('milestone_id')->nullable()->index();
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
     * @throws Throwable
     */
    public function down()
    {
        DB::beginTransaction();
        try {
            Schema::table('issue', function (Blueprint $table)
            {
                $table->dropColumn('milestone_id');
            });
            Schema::dropIfExists('milestone');

            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
