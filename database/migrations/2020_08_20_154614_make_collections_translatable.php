<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakeCollectionsTranslatable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Convert title and content to JSON
        Schema::table('collections', function (Blueprint $table) {
            $table->json('title_json')->after('title');
            $table->json('content_json')->nullable()->after('content');
        });

        DB::update("UPDATE collections set title_json = JSON_SET('{}', '$.sk', title)");
        DB::update("UPDATE collections set content_json = JSON_SET('{}', '$.sk', content)");

        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('content');

            $table->renameColumn('title_json', 'title');
            $table->renameColumn('content_json', 'content');
        });

        // Re-name content->description and drop cover_image
        Schema::table('collections', function (Blueprint $table) {
            $table->renameColumn('content', 'description');
            $table->dropColumn('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Re-add and re-name columns
        Schema::table('collections', function (Blueprint $table) {
            $table->string('cover_image')->after('slug')->nullable();
            $table->renameColumn('description', 'content');
        });

        // Convert from JSON back to text
        Schema::table('collections', function (Blueprint $table) {
            $table->string('title_string')->after('title');
            $table->text('content_string')->nullable()->after('content');
        });

        DB::update("UPDATE collections set title_string = title->>'$.sk'");
        DB::update("UPDATE collections set content_string = content->>'$.sk'");

        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('content');

            $table->renameColumn('title_string', 'title');
            $table->renameColumn('content_string', 'content');
        });
    }
}
