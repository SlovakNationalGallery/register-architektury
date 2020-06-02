<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_functions', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::table('buildings', function ($table) {
            $table->bigInteger('current_function_id')->nullable()->after('status');
            // $table->foreignId('current_function_id')->constrained('building_functions')->after('status');
            // $table->foreign('current_function_id')->references('id')->on('building_functions');
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
            $table->dropColumn('current_function_id');
        });

        Schema::dropIfExists('building_functions');
    }
}
