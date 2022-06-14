<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationColumnsToPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('title')->change();
            $table->longText('description')->change();
            $table->renameColumn('title', 'title_am');
            $table->renameColumn('description', 'description_am');
            $table->string('title_en');
            $table->longText('description_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->longText('description')->nullable()->change();
            $table->renameColumn('title_am', 'title');
            $table->renameColumn('description_am', 'description');
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');
        });
    }
}
