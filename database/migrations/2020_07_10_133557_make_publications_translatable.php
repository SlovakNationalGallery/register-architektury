<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakePublicationsTranslatable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('publications', function ($table) {
            $table->json('title_json')->after('title');
            $table->json('description_json')->nullable()->after('description');
        });

        DB::update("UPDATE publications set title_json = JSON_SET('{}', '$.sk', title)");
        DB::update("UPDATE publications set description_json = JSON_SET('{}', '$.sk', description)");

        Schema::table('publications', function ($table) {
            $table->dropColumn('title');
            $table->dropColumn('description');

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
        Schema::table('publications', function ($table) {
            $table->string('title_string')->after('title');
            $table->string('description_string')->nullable()->after('description');
        });

        DB::update("UPDATE publications set title_string = title->>'$.sk'");
        DB::update("UPDATE publications set description_string = description->>'$.sk'");

        Schema::table('publications', function ($table) {
            $table->dropColumn('title');
            $table->dropColumn('description');

            $table->renameColumn('title_string', 'title');
            $table->renameColumn('description_string', 'description');
        });
    }
}
