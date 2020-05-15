<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StoreLocationAsNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function ($table) {
            $table->float('location_lat', 10, 6)->nullable()->after('location_gps');
            $table->float('location_lon', 10, 6)->nullable()->after('location_lat');
            $table->dropColumn('location_gps');
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
            $table->string('location_gps')->nullable()->after('location_lon');
            $table->dropColumn(['location_lat', 'location_lon']);
        });
    }
}
