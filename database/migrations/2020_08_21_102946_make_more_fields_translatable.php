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
            $table->dropColumn('status');
        });

        Schema::table('buildings', function ($table) {
            $table->json('style')->nullable()->after('decade');
            $table->json('status')->nullable()->after('style');
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
            $table->dropColumn('status');
        });

        Schema::table('buildings', function ($table) {
            $table->string('style')->nullable()->after('decade');
            $table->string('status')->nullable()->after('style');
        });
    }
}
