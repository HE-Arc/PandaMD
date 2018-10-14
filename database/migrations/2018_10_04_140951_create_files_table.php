<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('folder_id');
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->longText('content');
            $table->boolean('is_title_page');
            $table->boolean('is_toc');
            $table->boolean('is_toc_own_page');
            $table->boolean('is_links_as_notes');
            $table->text('title');
            $table->text('subtitle');
            $table->text('school')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('files');
    }
}
