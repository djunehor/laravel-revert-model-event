<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('subject');
            $table->morphs('causer')->nullable();
            $table->string('description');
            $table->string('action');
            $table->json('old');
            $table->json('new');
            $table->string('route');
            $table->morphs('reverter');
            $table->timestamp('reverted_at')->nullable();
            $table->string('revert_note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_logs');
    }
}
