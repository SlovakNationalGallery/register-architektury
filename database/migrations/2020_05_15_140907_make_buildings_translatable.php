<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class MakeBuildingsTranslatable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function ($table) {
            $table->json('title_json')->after('title');
            $table->json('description_json')->nullable()->after('description');

            $table->dropColumn('title');
            $table->dropColumn('description');
        });

        Schema::table('buildings', function ($table) {
            $table->renameColumn('title_json', 'title');
            $table->renameColumn('description_json', 'description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function ($table) {
            $table->string('title')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }
}
