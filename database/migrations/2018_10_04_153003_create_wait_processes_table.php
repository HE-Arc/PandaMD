<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wait_processes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('token');
            $table->integer('status')->default('0'); //0 = running, 1 = finished, -1 = error
            $table->string('error_message')->nullable();
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
        Schema::dropIfExists('wait_processes');
    }
}
