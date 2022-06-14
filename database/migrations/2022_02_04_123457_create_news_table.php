<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title_am', 255)->nullable();
            $table->string('title_en', 255)->nullable();
            $table->longText('content_am')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('excerpt_am')->nullable();
            $table->longText('excerpt_en')->nullable();
            $table->boolean('is_main')->default(0);
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
        Schema::dropIfExists('news');
    }
}
