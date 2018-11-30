<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAuthors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('file_authors');
        Schema::dropIfExists('authors');
        Schema::table('files', function ($table) {
            $table->string('authors')->nullable();
            $table->longText('content')->nullable()->change();
            $table->boolean('is_title_page')->default(false)->change();
            $table->boolean('is_toc')->default(false)->change();
            $table->boolean('is_toc_own_page')->default(false)->change();
            $table->boolean('is_links_as_notes')->default(false)->change();
            $table->text('title')->nullable()->change();
            $table->text('subtitle')->nullable()->change();
            $table->date('date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function ($table) {
            $table->dropColumn('authors');
            $table->longText('content')->change();
            $table->boolean('is_title_page')->change();
            $table->boolean('is_toc')->change();
            $table->boolean('is_toc_own_page')->change();
            $table->boolean('is_links_as_notes')->change();
            $table->text('title')->change();
            $table->text('subtitle')->change();
            $table->date('date')->change();
        });
    }
}
