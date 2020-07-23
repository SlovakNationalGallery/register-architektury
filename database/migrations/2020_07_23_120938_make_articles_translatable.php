<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakeArticlesTranslatable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->json('title_json')->after('title');
            $table->json('content_json')->nullable()->after('content');
        });

        DB::update("UPDATE articles set title_json = JSON_SET('{}', '$.sk', title)");
        DB::update("UPDATE articles set content_json = JSON_SET('{}', '$.sk', content)");

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('content');

            $table->renameColumn('title_json', 'title');
            $table->renameColumn('content_json', 'content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title_string')->after('title');
            $table->text('content_string')->nullable()->after('content');
        });

        DB::update("UPDATE articles set title_string = title->>'$.sk'");
        DB::update("UPDATE articles set content_string = content->>'$.sk'");

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('content');

            $table->renameColumn('title_string', 'title');
            $table->renameColumn('content_string', 'content');
        });
    }
}
