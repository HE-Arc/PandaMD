<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

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
            $table->foreign('folder_id')->references('id')->on('folders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('content')->nullable();
            $table->boolean('is_title_page')->default(false);
            $table->boolean('is_toc')->default(false);
            $table->boolean('is_toc_own_page')->default(false);
            $table->boolean('is_links_as_notes')->default(false);
            $table->text('title')->default(Carbon::now()->toDateTimeString());
            $table->text('subtitle')->nullable();
            $table->text('school')->nullable();
            $table->date('date')->default(Carbon::now()->toDateString());
            $table->enum('security',['private','readable','editable'])->default('private');
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
