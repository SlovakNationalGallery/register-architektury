<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageSourcePathToArchitects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('architects', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('death_place');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('architects', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
}
