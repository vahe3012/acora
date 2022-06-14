<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 1000);

            $table->string('status', 20)->default('publish');

            $table->string('title', 1000)->nullable();

            $table->longText('content')->nullable();

            $table->string('meta_title', 255)->nullable();
            $table->text('canonical')->nullable();
            $table->text('meta_description')->nullable();

            $table->foreignId('main_image')->nullable();

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
        Schema::dropIfExists('pages');
    }
}
