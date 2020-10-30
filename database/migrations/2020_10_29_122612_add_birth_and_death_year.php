<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthAndDeathYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('architects', function (Blueprint $table) {
            $table->unsignedSmallInteger('birth_year')->nullable()->after('birth_date');
            $table->unsignedSmallInteger('death_year')->nullable()->after('death_date');
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
            $table->dropColumn('death_year');
            $table->dropColumn('birth_year');
        });
    }
}
