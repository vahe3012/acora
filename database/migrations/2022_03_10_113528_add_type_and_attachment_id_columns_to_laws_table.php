<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndAttachmentIdColumnsToLawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laws', function (Blueprint $table) {
            $table->string('link')->nullable()->change();
            $table->renameColumn('title', 'title_am');
            $table->string('title_en');
            $table->string('type')->default(\App\Models\Law::TYPE_LAW);
            $table->integer('attachment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laws', function (Blueprint $table) {
            $table->string('link')->change();
            $table->renameColumn('title_am', 'title');
            $table->dropColumn('title_en');
            $table->dropColumn('type');
            $table->dropColumn('attachment_id');
        });
    }
}
