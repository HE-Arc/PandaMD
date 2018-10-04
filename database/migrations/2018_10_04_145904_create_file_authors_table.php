<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('id_file');
            $table->foreign('id_file')->references('id')->on('files');
            $table->unsignedInteger('id_author');
            $table->foreign('id_author')->references('id')->on('authors');
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_authors');
    }
}
