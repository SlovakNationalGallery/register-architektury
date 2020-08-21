<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMoreFieldsTranslatable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function ($table) {
            $table->dropColumn('style');
        });

        Schema::table('buildings', function ($table) {
            $table->json('style')->nullable()->after('decade');
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
            $table->dropColumn('style');
        });

        Schema::table('buildings', function ($table) {
            $table->string('style')->nullable()->after('decade');
        });
    }
}
