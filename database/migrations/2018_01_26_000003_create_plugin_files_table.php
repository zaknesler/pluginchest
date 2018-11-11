<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugin_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('plugin_id')->unsigned()->index();
            $table->string('name');
            $table->string('stage');
            $table->text('description');
            $table->string('game_version');
            $table->integer('downloads_count')->default(0);
            $table->string('temporary_file')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->json('validation_errors')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('plugin_id')->references('id')->on('plugins')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugin_files');
    }
}
