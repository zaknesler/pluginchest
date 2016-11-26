<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plugin_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('name');
            $table->text('summary');
            $table->integer('downloads_count')->default(0);
            $table->string('file')->nullable();
            $table->string('game_version');
            $table->enum('stage', ['alpha', 'beta', 'release'])->default('alpha');
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
        Schema::dropIfExists('plugins_files');
    }
}
